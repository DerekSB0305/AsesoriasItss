<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Career;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'schedule' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Guardar archivo con nombre original
        if ($request->hasFile('schedule')) {
            $file = $request->file('schedule');
            $originalName = $file->getClientOriginalName();

            $path = $file->storeAs('teacher_schedules', $originalName, 'public');
            $validated['schedule'] = $path;
        }

        // Crear usuario maestro
        $user = User::create([
            'user'      => $request->teacher_user,
            'password'  => $request->teacher_user,
            'role_id'   => 3,
        ]);

        Teacher::create($validated);

        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor y usuario creado correctamente.');
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
            'teacher_user' => [
                'required',
                'string',
                'max:50',
                Rule::unique('teachers', 'teacher_user')->ignore($teacher->teacher_user, 'teacher_user')
            ],
            'name' => 'required|string|max:50',
            'last_name_f' => 'required|string|max:50',
            'last_name_m' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,career_id',
            'degree' => 'required|string|max:50',
            'tutor' => 'sometimes|boolean',
            'science_department' => 'sometimes|boolean',
            'schedule' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('schedule')) {

            if ($teacher->schedule && Storage::disk('public')->exists($teacher->schedule)) {
                Storage::disk('public')->delete($teacher->schedule);
            }

            $file = $request->file('schedule');
            $originalName = $file->getClientOriginalName();

            $validated['schedule'] = $file->storeAs('teacher_schedules', $originalName, 'public');
        }

        $oldUser = $teacher->teacher_user;
        $teacher->update($validated);

        //Actualiza el usuario maestro si el usuario cambia 
        $user = User::where('user', $oldUser)->first();

        if ($user) {
            $user->update([
                'user'     => $request->teacher_user,
            ]);
        }

        $teacher->update($validated);

        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Teacher $teacher)
    {
        //Eliminar archivo de horario
        if ($teacher->schedule && Storage::disk('public')->exists($teacher->schedule)) {
            Storage::disk('public')->delete($teacher->schedule);
        }

        $teacher->delete();
        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }

    // Modulo Maestro
    public function indexTeacher()
    {
        // Maestro logueado
        $teacher = Auth::user()->teacher;

        return view('teachers.index', compact('teacher'));
    }

    public function myAdvisories()
    {
           $teacherUser = auth()->user()->user;

    $advisories = \App\Models\Advisories::with([
        'teacherSubject.teacher',
        'teacherSubject.subject.career',
        'advisoryDetail.students'
    ])
        ->whereHas('teacherSubject', function ($q) use ($teacherUser) {
            $q->where('teacher_user', $teacherUser);
        })
        ->orderBy('start_date', 'ASC')
        ->orderBy('start_time', 'ASC')
        ->get();

    return view('teachers.advisories.index', compact('advisories'));
    }

    public function showChangePasswordForm()
    {
        return view('teachers.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('teachers.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    public function indexCareerHead()
{
    $admin = Auth::user()->administrative;

    if (!$admin) {
        return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
    }

    $careerId = $admin->career_id;

    $teachers = Teacher::where('career_id', $careerId)
        ->with('career')
        ->get();

    return view('career_head.teachers.index', compact('teachers'));
}

}
