<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role   = $request->input('role');

        $users = User::with('role')
            ->when($search, function ($q) use ($search) {
                $q->where('user', 'LIKE', "%{$search}%");
            })
            ->when($role, function ($q) use ($role) {
                $q->where('role_id', $role);
            })
            ->get();

        $roles = Role::all();
        return view('basic_sciences.users.index', compact('users', 'roles', 'role', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('basic_sciences.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|string|unique:users,user',
            'role_id' => 'required|integer|exists:roles,id',

        ]);

        User::create([
            'user'     => $request->user,
            'role_id'  => $request->role_id,
            // Usa el usuario como contraseña provisional 
            'password' => Hash::make($request->user),
        ]);

        return redirect()->route('basic_sciences.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();
        return view('basic_sciences.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('basic_sciences.users.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('basic_sciences.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
