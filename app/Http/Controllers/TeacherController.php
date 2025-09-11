<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('career')->get(); 
    return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $careers = Career::all(); // Traemos las carreras para el select
        return view('teachers.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,id',
            'study_degree' => 'required|string|max:50',
            'tutor' => 'sometimes|boolean',
        ]);

        \App\Models\Teacher::create($validated);
        return redirect()->route('teachers.index')
        ->with('success', 'Profesor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $careers = Career::all();
        return view('teachers.edit', compact('teacher', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,id',
            'study_degree' => 'required|string|max:50',
            'tutor' => 'sometimes|boolean',
        ]);

        $teacher->update($validated);
        return redirect()->route('teachers.index')->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Profesor eliminado correctamente.');
    }
}
