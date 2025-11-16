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

        $detail = Advisory_details::with('students')->findOrFail($detailId);

        // Todas las combinaciones maestro-materia-carrera
        $teacherSubjects = TeacherSubject::with(['teacher', 'subject', 'career'])->get();

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

        // Validacion de maestro unico
        $maestroYaTieneAsesoria = Advisories::where('teacher_subject_id', $request->teacher_subject_id)
            ->exists();

        if ($maestroYaTieneAsesoria) {
            return back()->withErrors([
                'teacher_subject_id' => 'Este maestro ya tiene una asesoría registrada y no puede tener más.'
            ])->withInput();
        }


        // Validacion de maestro - asesoria
        $conflictoMaestro = Advisories::where('teacher_subject_id', $request->teacher_subject_id)
            ->where('schedule', $schedule)
            ->exists();

        if ($conflictoMaestro) {
            return back()->withErrors([
                'schedule' => 'El maestro ya tiene una asesoría asignada en este horario.'
            ])->withInput();
        }

        // Validacion de aula - asesoria

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

        // Validacion de alumno - asesoria
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

        //    Todo validado → Guardar asesoría

        $path = null;
        if ($request->hasFile('assignment_file')) {
            $path = $request->file('assignment_file')->store('assignments', 'public');
        }

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

        // alumnos disponibles para esa materia (los que solicitaron asesoría)
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
        ]);

        $schedule = $request->schedule;

        // Validacion maestro unico
        $maestroYaTieneOtraAsesoria = Advisories::where('teacher_subject_id', $advisory->teacher_subject_id)
            ->where('advisory_id', '!=', $id)
            ->exists();

        if ($maestroYaTieneOtraAsesoria) {
            return back()->withErrors([
                'teacher_subject_id' => 'Este maestro ya tiene una asesoría y no puede tener otra.'
            ]);
        }

        /* Maestro no puede tener otra asesoría */
        $conflictoMaestro = Advisories::where('teacher_subject_id', $advisory->teacher_subject_id)
            ->where('schedule', $schedule)
            ->where('advisory_id', '!=', $id)
            ->exists();

        if ($conflictoMaestro) {
            return back()->withErrors(['schedule' => 'El maestro ya tiene una asesoría en este horario.']);
        }

        /* Aula no disponible */
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('schedule', $schedule)
                ->where('advisory_id', '!=', $id)
                ->exists();

            if ($conflictoAula) {
                return back()->withErrors(['classroom' => 'El aula ya está ocupada en este horario.']);
            }
        }

        /* Alumno no puede estar doble */
        foreach ($request->students as $enrollment) {
            $alumnoTieneAsesoria = Advisories::where('schedule', $schedule)
                ->where('advisory_id', '!=', $id)
                ->whereHas('advisoryDetail.students', function ($q) use ($enrollment) {
                    $q->where('students.enrollment', $enrollment);
                })->exists();


            if ($alumnoTieneAsesoria) {
                return back()->withErrors([
                    'schedule' => "El alumno ($enrollment) ya tiene una asesoría en este horario."
                ]);
            }
        }

        /* Guardar cambios */
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
            'advisoryDetail.students'
        ])->findOrFail($id);

        $students = $advisory->advisoryDetail->students ?? collect();

        $total = $students->count();
        $hombres = $students->where('gender', 'Masculino')->count();
        $mujeres = $students->where('gender', 'Femenino')->count();

        return view('basic_sciences.advisories.individual_details', compact(
            'advisory',
            'students',
            'total',
            'hombres',
            'mujeres'
        ));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $advisory = Advisories::findOrFail($id);
        $detail   = $advisory->advisoryDetail; // relación

        //  Borrar archivo si existe
        if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
            Storage::disk('public')->delete($advisory->assignment_file);
        }

        // Borrar alumnos del detalle
        if ($detail) {
            $detail->students()->detach();
        }

        // Borrar la asesoría
        $advisory->delete();

        // Borrar detalle_asesoría completo
        if ($detail) {
            $detail->delete();
        }

        return redirect()
            ->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría y detalle asociados eliminados correctamente.');
    }
}
