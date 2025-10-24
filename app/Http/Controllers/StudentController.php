<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['career', 'teacher'])->get();
        return view('basic_sciences.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::all();
        $teachers = Teacher::all();
        return view('basic_sciences.students.create', compact('careers', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         
      $validated = $request->validate([
            'enrollment' => 'required|string|max:8|unique:students,enrollment',
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:12',
            'career_id' => 'required|exists:careers,id',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:15|max:100',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        \App\Models\Student::create($validated);
        return redirect()->route('basic_sciences.students.index')
                         ->with('success', 'Estudiante registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['career', 'teacher']);
        return view('basic_sciences.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $careers = Career::all();
        $teachers = Teacher::all();
        return view('basic_sciences.students.edit', compact('student', 'careers', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:12',
            'career_id' => 'required|exists:careers,id',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:15|max:100',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);
        $student->update($request->all());

        return redirect()->route('basic_sciences.students.index')
                         ->with('success', 'Estudiante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
         $student->delete();

        return redirect()->route('basic_sciences.students.index')
                         ->with('success', 'Estudiante eliminado correctamente.');
    }
}
