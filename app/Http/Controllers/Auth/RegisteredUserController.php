<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrative;
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
            'user' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'user' => $request->user,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        switch ($request->role_id) {
        case 1: // Alumno
            Student::create([
                'matricula' => $request->username,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'id_carrera' => $request->id_carrera,
                'usuario_profesor' => $request->usuario_profesor,
            ]);
            break;

        case 2: // Profesor
            Teacher::create([
                'usuario_profesor' => $request->username,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'id_carrera' => $request->id_carrera,
                'grado_estudios' => $request->grado_estudios,
            ]);
            break;

        case 3: // Administrativo
            Administrative::create([
                'usuario_administrativo' => $request->username,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'cargo' => $request->cargo,
            ]);
            break;
    }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
