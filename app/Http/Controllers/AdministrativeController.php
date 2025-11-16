<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\Career;
use App\Models\Department;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
        'administrative_user' => 'required|string|max:50',
        'name' => 'required|string|max:50',
        'last_name_f' => 'required|string|max:50',
        'last_name_m' => 'required|string|max:50',
        'position' => 'required|string|max:50',
        'career_id' => 'nullable|exists:careers,career_id',
    ]);

    // Convertir nombres de la vista a nombres reales de la BD
    $administrative->update([
        'administrative_user' => $validated['administrative_user'],
        'name' => $validated['name'],
        'last_name_f' => $validated['last_name_f'],
        'last_name_m' => $validated['last_name_m'],
        'position' => $validated['position'],
        'career_id' => $validated['career_id'],
    ]);

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
}
