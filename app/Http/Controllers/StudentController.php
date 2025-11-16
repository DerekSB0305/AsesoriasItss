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
use Illuminate\Support\Facades\Storage;

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
            'enrollment'    => 'required|string|max:8|unique:students,enrollment',
            'last_name_f'   => 'required|string|max:50',
            'last_name_m'   => 'required|string|max:50',
            'name'          => 'required|string|max:40',
            'semester'      => 'required|integer',
            'group'         => 'required|string|max:5',
            'career_id'     => 'required|exists:careers,career_id',
            'gender'        => 'required|string|max:10',
            'age'           => 'required|integer',
            'schedule_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $teacherUser = Auth::user()->user; // usuario del maestro logueado

        // Datos base del alumno
        $studentData = $validated;
        $studentData['teacher_user'] = $teacherUser;

        // Guardar archivo de horario si viene
        if ($request->hasFile('schedule_file')) {
            $path = $request->file('schedule_file')->store('student_schedules', 'public');
            $studentData['schedule_file'] = $path;
        }

        // Guardar alumno
        $student = Student::create($studentData);

        // CREAR USUARIO AUTOMÁTICO PARA EL ALUMNO
        $defaultPassword = strtolower($validated['enrollment']); // contraseña = matrícula

        $roleAlumno = Role::where('role_type', 'Alumno')->first();

        User::create([
            'user'     => $validated['enrollment'],           // usuario = matrícula
            'password' => bcrypt($defaultPassword),           // contraseña encriptada
            'role_id'  => $roleAlumno->id,                    // rol alumno
        ]);

        return redirect()->route('teachers.students.index')
            ->with('success', 'Alumno registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
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
            'schedule_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data = $validated;

        // Si viene un nuevo archivo de horario
        if ($request->hasFile('schedule_file')) {

            // Borrar el archivo anterior si existe
            if ($student->schedule_file && Storage::disk('public')->exists($student->schedule_file)) {
                Storage::disk('public')->delete($student->schedule_file);
            }

            $path = $request->file('schedule_file')->store('student_schedules', 'public');
            $data['schedule_file'] = $path;
        } else {
            // Para que no intente guardar el UploadedFile vacío
            unset($data['schedule_file']);
        }

        $student->update($data);

        return redirect()
            ->route('teachers.students.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Borrar archivo de horario si existe
        if ($student->schedule_file && Storage::disk('public')->exists($student->schedule_file)) {
            Storage::disk('public')->delete($student->schedule_file);
        }

        // Borrar usuario asociado (user = matrícula)
        User::where('user', $student->enrollment)->delete();

        // Borrar alumno
        $student->delete();

        return redirect()->route('teachers.students.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}
