<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Advisory_details;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvisoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $detailId = $request->detail_id;

        if (!$detailId) {
            return redirect()->route('basic_sciences.advisory_details.create')
                ->with('error', 'Primero crea un detalle de asesoría.');
        }

        $detail = Advisory_details::with(['students'])->findOrFail($detailId);

        // 1) Obtener los maestros tutores que hicieron la solicitud
        $tutorUsers = \App\Models\Requests::whereIn(
                'enrollment',
                $detail->students->pluck('enrollment')
            )
            ->pluck('teacher_user')
            ->toArray();

        // 2) Filtrar maestros que NO sean tutores
        $teacherSubjects = \App\Models\TeacherSubject::with(['teacher', 'subject', 'career'])
            ->whereNotIn('teacher_user', $tutorUsers)
            ->get();

        return view('basic_sciences.advisories.create', compact('detail', 'teacherSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $schedule = $request->schedule;

        // Validación maestro ocupado en ese horario
        $conflictoMaestro = Advisories::where('teacher_subject_id', $request->teacher_subject_id)
            ->where('schedule', $schedule)
            ->exists();

        if ($conflictoMaestro) {
            return back()->withErrors([
                'schedule' => 'El maestro ya tiene una asesoría asignada en este horario.'
            ])->withInput();
        }

        // Validación aula ocupada
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('schedule', $schedule)
                ->exists();

            if ($conflictoAula) {
                return back()->withErrors([
                    'classroom' => 'El aula ya está asignada en este horario.'
                ])->withInput();
            }
        }

        // Validación alumno con asesoría en ese horario
        $detail = Advisory_details::with('students')->find($request->advisory_detail_id);

        foreach ($detail->students as $student) {
            $alumnoTieneAsesoria = Advisories::where('schedule', $schedule)
                ->whereHas('advisoryDetail.students', function ($q) use ($student) {
                    $q->where('students.enrollment', $student->enrollment);
                })->exists();

            if ($alumnoTieneAsesoria) {
                return back()->withErrors([
                    'schedule' => "El alumno {$student->name} ({$student->enrollment}) ya tiene una asesoría en este horario."
                ])->withInput();
            }
        }
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

        return redirect()
            ->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisories $advisories)
    {
        $advisories->load('detail.students', 'teacherSubject.teacher', 'teacherSubject.subject');

        return view('basic_sciences.advisories.show', compact('advisories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'teacherSubject.career',
            'advisoryDetail.students'
        ])->findOrFail($id);

        // alumnos inscritos actualmente
        $currentStudents = $advisory->advisoryDetail->students->pluck('enrollment')->toArray();

        // alumnos disponibles por materia
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $advisory = Advisories::findOrFail($id);

        $request->validate([
            'schedule' => 'required|date',
            'classroom' => 'nullable|string|max:10',
            'building'  => 'nullable|string|max:10',
            'students'  => 'required|array',
            'assignment_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        $schedule = $request->schedule;

        // Aula única
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('schedule', $schedule)
                ->where('advisory_id', '!=', $id)
                ->exists();

            if ($conflictoAula) {
                return back()->withErrors(['classroom' => 'El aula ya está ocupada en este horario.']);
            }
        }

        // Alumno no puede duplicar asesorías
        foreach ($request->students as $enrollment) {
            $conflictoAlumno = Advisories::where('schedule', $schedule)
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
        if ($request->hasFile('assignment_file')) {

            // Borrar archivo anterior si existe
            if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
                Storage::disk('public')->delete($advisory->assignment_file);
            }

            $file = $request->file('assignment_file');
            $originalName = $file->getClientOriginalName();

            $path = $file->storeAs('assignments', $originalName, 'public');

            $advisory->assignment_file = $path;
        }

        // Guardar cambios normales
        $advisory->update([
            'schedule' => $request->schedule,
            'classroom' => $request->classroom,
            'building'  => $request->building,
        ]);

        $advisory->advisoryDetail->students()->sync($request->students);

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría actualizada correctamente.');
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

    /**
     * Remove the specified resource from storage.
     */
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
}
