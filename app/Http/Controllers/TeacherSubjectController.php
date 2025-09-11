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
        return view('teacher_subjects.index', compact('teacherSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $careers = Career::all();
        return view('teacher_subjects.create', compact('teachers', 'subjects', 'careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'career_id' => 'required|exists:careers,id',
        ]);

        TeacherSubject::create($request->all());
        return redirect()->route('teacher_subjects.index')
                         ->with('success', 'Asignación registrada correctamente.');
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
    public function edit(TeacherSubject $teacherSubject)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $careers = Career::all();
        return view('teacher_subjects.edit', compact('teacherSubject', 'teachers', 'subjects', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'career_id' => 'required|exists:careers,id',
        ]);

        $teacherSubject->update($request->all());
        return redirect()->route('teacher_subjects.index')
                         ->with('success', 'Asignación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();
        return redirect()->route('teacher_subjects.index')
                         ->with('success', 'Asignación eliminada correctamente.');
    }
}
