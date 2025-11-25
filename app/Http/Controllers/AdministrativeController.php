<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\Career;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administratives = Administrative::with('career')->get();
        return view('basic_sciences.administratives.index', compact('administratives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::all();
        return view('basic_sciences.administratives.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'administrative_user' => 'required|string|max:20|unique:administratives,administrative_user',
            'name' => 'required|string|max:50',
            'last_name_f' => 'required|string|max:50',
            'last_name_m' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,career_id',
        ]);

        $user = \App\Models\User::create([
            'user'     => $request->administrative_user,
            'password' => $request->administrative_user,
            'role_id'  => 2,
        ]);


        Administrative::create($validated);

        return redirect()->route('basic_sciences.administratives.index')->with('success', 'Administrativo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrative $administrative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrative $administrative)
    {
        $careers = Career::all();
        return view('basic_sciences.administratives.edit', compact('administrative', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrative $administrative)
    {
        $oldUser = $administrative->administrative_user;

        $validated = $request->validate([
            'administrative_user' => 'required|string|max:50|unique:administratives,administrative_user,' . $administrative->administrative_user . ',administrative_user',
            'name' => 'required|string|max:50',
            'last_name_f' => 'required|string|max:50',
            'last_name_m' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'career_id' => 'nullable|exists:careers,career_id',
        ]);

        // Actualizar administrativo
        $administrative->update($validated);

        // Actualizar usuario en tabla users
        $user = \App\Models\User::where('user', $oldUser)->first();

        if ($user) {
            $user->update([
                'user' => $validated['administrative_user'],
            ]);
        }

        return redirect()
            ->route('basic_sciences.administratives.index')
            ->with('success', 'Administrativo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrative $administrative)
    {
        $administrative->delete();
        return redirect()->route('basic_sciences.administratives.index')->with('success', 'Administrativo eliminado exitosamente.');
    }

    public function indexCareerHead()
    {
        // Obtener al administrativo del usuario logueado
        $admin = Auth::user()->administrative;

        if (!$admin) {
            return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
        }

        //  Verificar si contraseña es igual a usuario
        $passwordIgual = Hash::check($admin->administrative_user, Auth::user()->password);

        // Enviar variable a la vista
        return view('career_head.index', compact('admin', 'passwordIgual'));
    }


    /**
     * Verificar si el administrativo debe cambiar su contraseña
     */
    public function checkPasswordStatus()
    {
        $user = Auth::user();

        // Si no es administrativo, no hacemos nada
        if (!$user || !$user->administrative) {
            return null;
        }

        $admin = $user->administrative;

        // Comparar contraseña con su usuario
        $passwordDefault = Hash::check($admin->administrative_user, $user->password);

        return $passwordDefault;
    }

    public function changePasswordForm()
    {
        return view('career_head.change_password');
    }

    public function changePasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('career_head.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
