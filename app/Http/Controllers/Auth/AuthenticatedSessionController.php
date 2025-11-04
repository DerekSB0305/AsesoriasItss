<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
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

    // Intentar autenticación con campo 'user' en lugar de 'email'
    if (!Auth::attempt($request->only('user', 'password'), $request->boolean('remember'))) {
        return back()->withErrors([
            'user' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    $request->session()->regenerate();
    $user = Auth::user();

    // Detectar el tipo de rol
    $role = strtolower(trim($user->role->role_type ?? ''));

    if (!$role) {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'user' => 'Tu cuenta no tiene un rol asignado, contacta al administrador.',
        ]);
    }

    // ✅ Redirección manual (anula el dashboard)
    switch ($role) {
        case 'ciencias básicas':
        case 'ciencias basicas':
            return redirect()->route('basic_sciences.index');

        case 'jefatura':
            return redirect()->route('jefatura.dashboard');

        case 'docente':
        case 'maestro':
        case 'profesor':
            return redirect()->route('teachers.index'); 

        case 'alumno':
            return redirect()->route('alumno.dashboard');

        default:
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'user' => 'Rol desconocido. Contacta al administrador.',
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
