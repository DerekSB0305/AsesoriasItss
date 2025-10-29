<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrative;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::orderBy('rol_type')->get();

        $students = Student::select('enrollment')->orderby('enrollment')->get();
        $teachers = Teacher::select('teacher_user')->orderby('teacher_user')->get();
        $administratives = Administrative::select('administrative_user')->orderby('administrative_user')->get();

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role_id'   => ['required','exists:roles,id'],
            'user'      => ['required','string','max:50','unique:users,user'],
            'password'  => ['required','string','min:8','confirmed'],
        ]);

        $role = Role::findOrFail($request->role_id);
        $roleName = mb_strtolower($role->role_type);

        $exists = false;

        switch ($roleName) {
            case 'alumno':
                $exists = Student::where('enrollment', $request->user)->exists();
                break;

            case 'profesor':
                $exists = Teacher::where('teacher_user', $request->user)->exists();
                break;

            case 'ciencias básicas':
            case 'jefatura':
            case 'administrativo':
                $exists = Administrative::where('administrative_user', $request->user)->exists();
                break;

            default:
                $exists = false;
        }

        if (!$exists) {
            return back()
                ->withErrors(['user' => 'El identificador no existe en la entidad correspondiente al rol seleccionado.'])
                ->withInput();
        }

        // Crear el usuario
        User::create([
            'user'     => $request->user,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('login')->with('success', 'Usuario creado correctamente.');
    }
}
