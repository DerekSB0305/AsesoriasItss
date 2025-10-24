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
      $administratives = Administrative::all();
        return view('basic_sciences.administratives.index', compact('administratives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('basic_sciences.administratives.create');
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
        // $departments = Department::all();
        return view('basic_sciences.administratives.edit', compact('administrative'));
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
        ]);

        $administrative->update($validated);

        return redirect()->route('basic_sciences.administratives.index')->with('success', 'Administrativo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrative $administrative)
    {
        $administrative->delete();
        return redirect()->route('basic_sciences.administratives.index')->with('success', 'Administrativo eliminado exitosamente.');
    }
}
