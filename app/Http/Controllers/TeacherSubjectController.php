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
    public function index()
    {
        $teacherSubjects = TeacherSubject::with(['teacher', 'subject', 'career'])->get();
        return view('basic_sciences.teacher_subjects.index', compact('teacherSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $careers = Career::all();
        return view('basic_sciences.teacher_subjects.create', compact('teachers', 'subjects', 'careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
        'teacher_user' => 'required|string|exists:teachers,teacher_user',
        'subjects'     => 'required|array', // subjects[subject_id][career_id]
    ]);

    $duplicados = 0;

    foreach($request->subjects as $data){
        if(!isset($data['subject_id']) || !isset($data['career_id'])){
            continue; // si no marcaron la materia, skip
        }

        $exists = TeacherSubject::where('teacher_user', $request->teacher_user)
            ->where('subject_id', $data['subject_id'])
            ->where('career_id', $data['career_id'])
            ->exists();

        if($exists){
            $duplicados++;
            continue;
        }

        TeacherSubject::create([
            'teacher_user' => $request->teacher_user,
            'subject_id'   => $data['subject_id'],
            'career_id'    => $data['career_id'],
        ]);
    }

    $msg = $duplicados > 0
        ? "Algunas materias ya estaban asignadas"
        : "Materias asignadas correctamente";

    return redirect()->route('basic_sciences.teacher_subjects.index')
        ->with('success',$msg);
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
