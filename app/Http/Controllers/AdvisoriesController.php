<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Advisory_details;
use App\Models\TeacherSubject;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage;

class AdvisoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Advisories::with(['teacherSubject.teacher', 'teacherSubject.subject']);

        if ($request->q) {
            $query->whereHas('teacherSubject.teacher', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->q . '%');
            })->orWhereHas('teacherSubject.subject', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->q . '%');
            });
        }

        $advisories = $query->get();

        return view('basic_sciences.advisories.index', compact('advisories'));
    }

    public function create(Request $request)
    {
        $detailId = $request->detail_id;

        if (!$detailId) {
            return redirect()->route('basic_sciences.advisory_details.create')
                ->with('error', 'Primero crea un detalle de asesoría.');
        }

        $detail = Advisory_details::with(['students'])->findOrFail($detailId);

        $tutorUsers = \App\Models\Requests::whereIn(
            'enrollment',
            $detail->students->pluck('enrollment')
        )
            ->pluck('teacher_user')
            ->toArray();

        $teacherSubjects = \App\Models\TeacherSubject::with(['teacher', 'subject', 'career'])
            ->whereNotIn('teacher_user', $tutorUsers)
            ->get();

        return view('basic_sciences.advisories.create', compact('detail', 'teacherSubjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'advisory_detail_id' => 'required|exists:advisory_details,advisory_detail_id',
            'teacher_subject_id' => 'required|exists:teacher_subjects,teacher_subject_id',
            'schedule'           => 'required|date',
            'classroom'          => 'nullable|string|max:10',
            'building'           => 'nullable|string|max:10',
            'assignment_file'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        // ---------------------------
        // VALIDACIÓN DE DÍA Y HORA
        // ---------------------------
        $timestamp = strtotime($request->schedule);
        $hour = intval(date('H', $timestamp));
        $day = date('N', $timestamp); // 1=Lunes, 7=Domingo

        if ($day >= 6) {
            return back()->withErrors([
                'schedule' => 'No se pueden crear asesorías sábado ni domingo.'
            ])->withInput();
        }

        if ($hour < 6 || $hour > 18) {
            return back()->withErrors([
                'schedule' => 'La asesoría debe estar entre las 6:00 AM y 6:00 PM.'
            ])->withInput();
        }

        // Validación maestro ocupado
        $schedule = $request->schedule;
        $conflictoMaestro = Advisories::where('teacher_subject_id', $request->teacher_subject_id)
            ->where('schedule', $schedule)
            ->exists();

        if ($conflictoMaestro) {
            return back()->withErrors([
                'schedule' => 'El maestro ya tiene una asesoría en ese horario.'
            ])->withInput();
        }

        // Validación aula ocupada
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('schedule', $schedule)
                ->exists();
            if ($conflictoAula) {
                return back()->withErrors([
                    'classroom' => 'El aula ya está asignada en ese horario.'
                ])->withInput();
            }
        }

        // Validación alumno ocupado
        $detail = Advisory_details::with('students')->find($request->advisory_detail_id);

        foreach ($detail->students as $student) {
            $alumnoTieneAsesoria = Advisories::where('schedule', $schedule)
                ->whereHas('advisoryDetail.students', function ($q) use ($student) {
                    $q->where('students.enrollment', $student->enrollment);
                })->exists();

            if ($alumnoTieneAsesoria) {
                return back()->withErrors([
                    'schedule' => "El alumno {$student->name} ({$student->enrollment}) ya tiene asesoría en ese horario."
                ])->withInput();
            }
        }

        // GUARDAR ARCHIVO CON NOMBRE ORIGINAL
        $path = null;
        if ($request->hasFile('assignment_file')) {
            $file = $request->file('assignment_file');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('assignments', $originalName, 'public');
        }

        // Crear asesoría
        $advisory = Advisories::create([
            'advisory_detail_id' => $request->advisory_detail_id,
            'teacher_subject_id' => $request->teacher_subject_id,
            'schedule'           => $schedule,
            'classroom'          => $request->classroom,
            'building'           => $request->building,
            'assignment_file'    => $path,
        ]);

        // Cambiar estado de PENDIENTE → APROBADO
        $detail->update(['status' => 'Aprobado']);

        return redirect()
            ->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría creada correctamente.');
    }

    public function edit($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'teacherSubject.career',
            'advisoryDetail.students'
        ])->findOrFail($id);

        $currentStudents = $advisory->advisoryDetail->students->pluck('enrollment')->toArray();

        $students = \App\Models\Requests::where('subject_id', $advisory->teacherSubject->subject_id)
            ->with('student')
            ->get()
            ->map(function ($req) {
                return [
                    'enrollment' => $req->student->enrollment,
                    'name'       => $req->student->name . ' ' . $req->student->last_name_f,
                ];
            });

        return view('basic_sciences.advisories.edit', compact('advisory', 'students', 'currentStudents'));
    }

    public function update(Request $request, $id)
    {
        $advisory = Advisories::findOrFail($id);

        $request->validate([
            'schedule' => 'required|date',
            'classroom' => 'nullable|string|max:10',
            'building'  => 'nullable|string|max:10',
            'students'  => 'required|array',
            'assignment_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
            'status' => 'nullable|string|in:Aprobado,Finalizado'
        ]);

        // Validación día/hora
        $timestamp = strtotime($request->schedule);
        $hour = intval(date('H', $timestamp));
        $day = date('N', $timestamp);

        if ($day >= 6) {
            return back()->withErrors(['schedule' => 'No se pueden asignar asesorías sábado o domingo.'])->withInput();
        }

        if ($hour < 6 || $hour > 18) {
            return back()->withErrors(['schedule' => 'La asesoría debe ser entre 6 AM y 6 PM.'])->withInput();
        }

        // Conflictos
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('schedule', $request->schedule)
                ->where('advisory_id', '!=', $id)
                ->exists();

            if ($conflictoAula) {
                return back()->withErrors(['classroom' => 'El aula ya está ocupada en este horario.']);
            }
        }

        foreach ($request->students as $enrollment) {
            $conflictoAlumno = Advisories::where('schedule', $request->schedule)
                ->where('advisory_id', '!=', $id)
                ->whereHas('advisoryDetail.students', function ($q) use ($enrollment) {
                    $q->where('students.enrollment', $enrollment);
                })->exists();

            if ($conflictoAlumno) {
                return back()->withErrors([
                    'schedule' => "El alumno ($enrollment) ya tiene asesoría en este horario."
                ]);
            }
        }

        // Guardar nuevo archivo con nombre original
        if ($request->hasFile('assignment_file')) {

            if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
                Storage::disk('public')->delete($advisory->assignment_file);
            }

            $file = $request->file('assignment_file');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('assignments', $originalName, 'public');

            $advisory->assignment_file = $path;
        }

        // Actualizar asesoría
        $advisory->update([
            'schedule' => $request->schedule,
            'classroom' => $request->classroom,
            'building'  => $request->building,
        ]);

        // Sincronizar alumnos
        $advisory->advisoryDetail->students()->sync($request->students);

        // Actualizar estado si se envió
        if ($request->status) {
            $advisory->advisoryDetail->update(['status' => $request->status]);
        }

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        $advisory = Advisories::findOrFail($id);
        $detail   = $advisory->advisoryDetail;

        if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
            Storage::disk('public')->delete($advisory->assignment_file);
        }

        if ($detail) {
            $detail->students()->detach();
        }

        $advisory->delete();

        if ($detail) {
            $detail->delete();
        }

        return redirect()
            ->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría y detalle eliminados correctamente.');
    }

    public function details($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject.career',
            'teacherSubject.career',
            'advisoryDetail.students',
            'reports'
        ])->findOrFail($id);

        $students = $advisory->advisoryDetail->students ?? collect();

        $total = $students->count();
        $hombres = $students->where('gender', 'Masculino')->count();
        $mujeres = $students->where('gender', 'Femenino')->count();

        $reports = $advisory->reports;

        return view('basic_sciences.advisories.individual_details', compact(
            'advisory',
            'students',
            'total',
            'hombres',
            'mujeres',
            'reports'
        ));
    }

    public function indexCareerHead()
    {
        $admin = FacadesAuth::user()->administrative;

        if (!$admin) {
            return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
        }

        $careerId = $admin->career_id;

        $advisories = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'advisoryDetail.students'
        ])
            ->whereHas('teacherSubject', function ($q) use ($careerId) {
                $q->where('career_id', $careerId);
            })
            ->get();

        return view('career_head.advisories.index', compact('advisories'));
    }
}
