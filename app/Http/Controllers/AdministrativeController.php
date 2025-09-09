<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\Department;
use Illuminate\Http\Request;

class AdministrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $administratives = Administrative::with('department')->get();
        return view('administratives.index', compact('administratives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('administratives.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
        ]);

        Administrative::create($validated);

        return redirect()->route('administratives.index')->with('success', 'Administrativo creado exitosamente.');
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
        $departments = Department::all();
        return view('administratives.edit', compact('administrative', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrative $administrative)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name_father' => 'required|string|max:50',
            'last_name_mother' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
        ]);

        $administrative->update($validated);

        return redirect()->route('administratives.index')->with('success', 'Administrativo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrative $administrative)
    {
        $administrative->delete();
        return redirect()->route('administratives.index')->with('success', 'Administrativo eliminado exitosamente.');
    }
}
