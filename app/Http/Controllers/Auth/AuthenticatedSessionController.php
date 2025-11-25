<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->validate([
        'user' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    // Buscar usuario por nombre de usuario
    $usuario = \App\Models\User::where('user', $request->user)->first();

    // Usuario NO existe
    if (!$usuario) {
        return back()->withErrors([
            'user' => 'El usuario ingresado no existe.',
        ])->withInput();
    }

    // Usuario SÍ existe, pero contraseña incorrecta
    if (!Hash::check($request->password, $usuario->password)) {
        return back()->withErrors([
            'password' => 'La contraseña es incorrecta.',
        ])->withInput();
    }

    // Intentar login usando Auth::login()
    Auth::login($usuario, $request->boolean('remember'));
    $request->session()->regenerate();

    $user = Auth::user();

    //  Usuario sin rol asignado
    $role = strtolower(trim($user->role->role_type ?? ''));
    if (!$role) {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'user' => 'Tu cuenta no tiene un rol asignado. Contacta al administrador.',
        ]);
    }

    //  Redirección según rol
    switch ($role) {
        case 'ciencias básicas':
        case 'ciencias basicas':
            return redirect()->route('basic_sciences.index');

        case 'jefatura de division':
            return redirect()->route('career_head.index');

        case 'docente':
        case 'maestro':
        case 'profesor':
            return redirect()->route('teachers.index');

        case 'alumno':
        case 'alumnos':
        case 'estudiante':
        case 'student':
            return redirect()->route('students.panel.index');

        default:
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'user' => 'Tu rol no está reconocido por el sistema.',
            ]);
    }
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
