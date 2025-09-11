<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('career')->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::all();
        return view('subjects.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'credits' => 'required|integer|min:1|max:10',
            'career_id' => 'required|exists:careers,id',
        ]);

        Subject::create($request->all());
        return redirect()->route('subjects.index')
                         ->with('success', 'Materia registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $careers = Career::all();
        return view('subjects.edit', compact('subject', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'credits' => 'required|integer|min:1|max:10',
            'career_id' => 'required|exists:careers,id',
        ]);

        $subject->update($request->all());
        return redirect()->route('subjects.index')
                         ->with('success', 'Materia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
                         ->with('success', 'Materia eliminada correctamente.');
    }
}
