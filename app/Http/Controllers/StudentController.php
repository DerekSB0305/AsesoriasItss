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

    public function create()
    {
        $careers = Career::all();
        return view('teachers.students.create', compact('careers'));
    }

    /**
     * ===========================================
     * STORE → guardar archivo como {matricula}_horario.ext
     * ===========================================
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

        $teacherUser = Auth::user()->user;

        $studentData = $validated;
        $studentData['teacher_user'] = $teacherUser;

        /**
         * SUBIR ARCHIVO COMO matricula_horario.ext
         */
        if ($request->hasFile('schedule_file')) {

            $file = $request->file('schedule_file');
            $ext = $file->getClientOriginalExtension();

            // nombre base
            $baseName = $validated['enrollment'] . "_horario";
            $folder = 'student_schedules';

            // obtener nombre final evitando duplicados
            $finalName = $this->avoidDuplicateNames($folder, $baseName, $ext);

            $path = $file->storeAs($folder, $finalName, 'public');

            $studentData['schedule_file'] = $path;
        }

        $student = Student::create($studentData);

        // Crear usuario automático del alumno
        $defaultPassword = strtolower($validated['enrollment']);
        $roleAlumno = Role::where('role_type', 'Alumno')->first();

        User::create([
            'user'     => $validated['enrollment'],
            'password' => bcrypt($defaultPassword),
            'role_id'  => $roleAlumno->id,
        ]);

        return redirect()->route('teachers.students.index')
            ->with('success', 'Alumno registrado correctamente.');
    }
    public function edit(Student $student)
    {
        $careers = Career::all();
        return view('teachers.students.edit', compact('student', 'careers'));
    }

    /**
     * ===========================================
     * UPDATE → también usa matricula_horario.ext
     * ===========================================
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

        if ($request->hasFile('schedule_file')) {

            // Borrar archivo anterior
            if ($student->schedule_file && Storage::disk('public')->exists($student->schedule_file)) {
                Storage::disk('public')->delete($student->schedule_file);
            }

            $file = $request->file('schedule_file');
            $ext = $file->getClientOriginalExtension();

            $baseName = $student->enrollment . "_horario";
            $folder = 'student_schedules';

            // evitar repetidos
            $finalName = $this->avoidDuplicateNames($folder, $baseName, $ext);

            $path = $file->storeAs($folder, $finalName, 'public');
            $data['schedule_file'] = $path;

        } else {
            unset($data['schedule_file']);
        }

        $student->update($data);

        return redirect()
            ->route('teachers.students.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Student $student)
    {
        if ($student->schedule_file && Storage::disk('public')->exists($student->schedule_file)) {
            Storage::disk('public')->delete($student->schedule_file);
        }

        User::where('user', $student->enrollment)->delete();
        $student->delete();

        return redirect()->route('teachers.students.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }

    /**
     * ============================================================
     * FUNCIÓN PARA EVITAR NOMBRES REPETIDOS:
     * base.ext → base(1).ext → base(2).ext ...
     * ============================================================
     */
    private function avoidDuplicateNames($folder, $baseName, $ext)
    {
        $disk = Storage::disk('public');

        $filename = $baseName . '.' . $ext;
        $counter = 1;

        while ($disk->exists("$folder/$filename")) {
            $filename = $baseName . "($counter)." . $ext;
            $counter++;
        }

        return $filename;
    }
}
