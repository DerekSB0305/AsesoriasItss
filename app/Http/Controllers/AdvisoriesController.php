<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Advisory_details;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdvisoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advisories = Advisories::with(['teacher', 'subject', 'detail.student'])->get();

    return view('basic_sciences.advisories.index', compact('advisories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $detailId = $request->query('detail_id'); 
         if (!$detailId) {
            return redirect()->route('basic_sciences.advisory_details.create')
                ->with('Primero debes registrar el detalle de la asesoría.');
        }
        $teachers = Teacher::all();

    return view('basic_sciences.advisories.create', compact('teachers', 'detailId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
          'teacher_user' => 'required|string|exists:teachers,teacher_user',
            'subject_id' => 'required|integer|exists:subjects,id',
            'schedule' => 'required|date',
            'classroom' => 'required|string|max:10',
            'building' => 'required|string|max:10',
            'assignment_sheet' => 'nullable|string|max:45',
            'advisory_detail_id' => 'required|integer|exists:advisory_details,id',
    ]);

    Advisories::create([
    'teacher_user' => $validated['teacher_user'],
    'advisory_detail_id' => $request->advisory_detail_id,
    'subject_id' => $validated['subject_id'],
    'schedule' => $validated['schedule'],
    'classroom' => $validated['classroom'],
    'building' => $validated['building'],
       ]);


    return redirect()->route('basic_sciences.advisories.index')
        ->with('success', 'Asesoría registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisories $advisories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advisories $advisories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisories $advisories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisories $advisories)
    {
         $advisory = Advisories::findOrFail($advisories->id);

        if ($advisory->detail) {
            $advisory->detail->delete();
        }

        $advisory->delete();

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría eliminada correctamente.');
    
    }
}
