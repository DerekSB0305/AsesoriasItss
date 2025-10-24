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
    return view('basic_sciences.teachers.index', compact('teachers'));
}

public function create()
{
    $careers = Career::all();
    return view('basic_sciences.teachers.create', compact('careers'));
}

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

    Teacher::create($validated);

    return redirect()->route('basic_sciences.teachers.index')
        ->with('success', 'Profesor creado correctamente.');
}

public function show(Teacher $teacher)
{
    return view('basic_sciences.teachers.show', compact('teacher'));
}

public function edit(Teacher $teacher)
{
    $careers = Career::all();
    return view('basic_sciences.teachers.edit', compact('teacher', 'careers'));
}

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
    return redirect()->route('basic_sciences.teachers.index')
        ->with('success', 'Profesor actualizado correctamente.');
}

public function destroy(Teacher $teacher)
{
    $teacher->delete();
    return redirect()->route('basic_sciences.teachers.index')
        ->with('success', 'Profesor eliminado correctamente.');
}
}
