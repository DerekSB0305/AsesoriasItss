<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
           $searchTeacher = $request->search_teacher;
        $searchSubject = $request->search_subject;
        $searchCareer  = $request->search_career;

        $query = TeacherSubject::with(['teacher', 'subject', 'career']);

        // Filtro por maestro
        if (!empty($searchTeacher)) {
            $query->whereHas('teacher', function($q) use ($searchTeacher) {
                $q->where('name', 'LIKE', "%$searchTeacher%")
                  ->orWhere('last_name_f', 'LIKE', "%$searchTeacher%")
                  ->orWhere('last_name_m', 'LIKE', "%$searchTeacher%");
            });
        }

        // Filtro por materia
        if (!empty($searchSubject)) {
            $query->whereHas('subject', function($q) use ($searchSubject) {
                $q->where('name', 'LIKE', "%$searchSubject%");
            });
        }

        // Filtro por carrera
        if (!empty($searchCareer)) {
            $query->whereHas('career', function($q) use ($searchCareer) {
                $q->where('name', 'LIKE', "%$searchCareer%");
            });
        }

        // Obtener resultados
        $teacherSubjects = $query->get();
        return view('basic_sciences.teacher_subjects.index', compact('teacherSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::where('science_department', 1)->get();

    $subjects = Subject::all();
    $careers  = Career::all();

    return view('basic_sciences.teacher_subjects.create',
                compact('teachers', 'subjects', 'careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'teacher_user' => 'required|exists:teachers,teacher_user',
        'subjects' => 'required|array|min:1',
        'subjects.*.subject_id' => 'required|exists:subjects,subject_id',
        'subjects.*.career_id' => 'required|exists:careers,career_id',
    ], [
        'teacher_user.required' => 'Debes seleccionar un maestro.',
        'teacher_user.exists' => 'El maestro seleccionado no existe.',
        'subjects.required' => 'Debes agregar al menos una materia.',
        'subjects.*.subject_id.required' => 'Debes seleccionar una materia.',
        'subjects.*.career_id.required' => 'Debes seleccionar una carrera.',
    ]);

    $teacherUser = $request->teacher_user;

    foreach ($request->subjects as $materia) {

        // Verificar duplicados
        $existe = \App\Models\TeacherSubject::where('teacher_user', $teacherUser)
            ->where('subject_id', $materia['subject_id'])
            ->where('career_id', $materia['career_id'])
            ->exists();

        if ($existe) {
            return back()
                ->withErrors([
                    'duplicado' => 'El maestro ya tiene asignada la materia seleccionada en esa carrera.'
                ])
                ->withInput();
        }

        // Crear asignación
        \App\Models\TeacherSubject::create([
            'teacher_user' => $teacherUser,
            'subject_id' => $materia['subject_id'],
            'career_id' => $materia['career_id'],
        ]);
    }

    return redirect()
        ->route('basic_sciences.teacher_subjects.index')
        ->with('success', 'Materias asignadas correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherSubject $teacherSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherSubject $teacher_subject)
    {
       $teachers = Teacher::all();
    $subjects = Subject::all();
    $careers  = Career::all();

    return view('basic_sciences.teacher_subjects.edit', [
        'teacherSubject' => $teacher_subject,
        'teachers' => $teachers,
        'subjects' => $subjects,
        'careers' => $careers,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $teacher_subject_id)
    {
         $request->validate([
        'subject_id' => 'required|integer|exists:subjects,subject_id',
        'career_id'  => 'required|integer|exists:careers,career_id',
    ]);

    $record = TeacherSubject::where('teacher_subject_id',$teacher_subject_id)->firstOrFail();

    $record->update([
        'subject_id' => $request->subject_id,
        'career_id'  => $request->career_id,
    ]);

    return redirect()->route('basic_sciences.teacher_subjects.index')
        ->with('success','Asignación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();
        return redirect()->route('basic_sciences.teacher_subjects.index')
                         ->with('success', 'Asignación eliminada correctamente.');
    }
}
