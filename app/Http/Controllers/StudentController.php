<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function indexTeacher()
    {
        $teacher_user = Auth::user()->user;

        $students = Student::where('teacher_user', $teacher_user)->get();

        return view('teachers.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $careers = Career::all();
    return view('teachers.students.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
        'enrollment' => 'required|string|max:8|unique:students,enrollment',
        'last_name_f' => 'required|string|max:50',
        'last_name_m' => 'required|string|max:50',
        'name' => 'required|string|max:40',
        'semester' => 'required|integer',
        'group' => 'required|string|max:5',
        'career_id' => 'required|exists:careers,career_id',
        'gender' => 'required|string|max:10',
        'age' => 'required|integer',
    ]);

    $teacherUser = Auth::user()->user; // usuario del maestro logueado

    // guardar alumno
    $student = Student::create([
        ...$validated,
        'teacher_user' => $teacherUser,
    ]);

    // CREAR USUARIO AUTOMATICO PARA EL ALUMNO
    $defaultPassword = strtolower($validated['enrollment']); // contraseña = matrícula

    $roleAlumno = Role::where('role_type', 'Alumno')->first(); // <-- aquí usamos el rol exacto

    User::create([
        'user' => $validated['enrollment'],            // el usuario será la matrícula
        'password' => bcrypt($defaultPassword),        // contraseña encriptada
        'role_id' => $roleAlumno->id,                  // rol alumno
    ]);

    return redirect()->route('teachers.students.index')
        ->with('success','Alumno registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $careers = Career::all();
        return view('teachers.students.edit', compact('student', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'last_name_f'    => 'required|string|max:100',
            'last_name_m'    => 'nullable|string|max:100',
            'semester'       => 'required|integer|min:1|max:12',
            'group'          => 'required|string|max:5',
            'gender'         => 'required|string|max:20',
            'age'            => 'required|integer|min:1|max:120',
            'career_id'      => 'required|exists:careers,career_id',
        ]);

        $student->update($validated);

        return redirect()
            ->route('teachers.students.index')
            ->with('success', 'Alumno actualizado correctamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('teachers.students.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}
