<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Career;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        'teacher_user' => 'required|string|max:50|unique:teachers,teacher_user',
        'name' => 'required|string|max:50',
        'last_name_f' => 'required|string|max:50',
        'last_name_m' => 'required|string|max:50',
        'career_id' => 'required|exists:careers,career_id',
        'degree' => 'required|string|max:50',
        'tutor' => 'sometimes|boolean',
        'science_department' => 'sometimes|boolean',
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
        'teacher_user' => 'required|string|max:50|unique:teachers,teacher_user,',
        'name' => 'required|string|max:50',
        'last_name_f' => 'required|string|max:50',
        'last_name_m' => 'required|string|max:50',
        'career_id' => 'required|exists:careers,career_id',
        'degree' => 'required|string|max:50',
        'tutor' => 'sometimes|boolean',
        'science_department' => 'sometimes|boolean',
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

// Modulo Maestro
    public function indexTeacher()
    {
            $teacher = Auth::user()->user; // o el modelo teacher
    $advisories = Advisories::where('teacher_user', $teacher)->get();

    return view('teachers.index', compact('advisories'));
    }
}
