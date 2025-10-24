<?php

namespace App\Http\Controllers;

use App\Models\Advisory_details;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdvisoryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('basic_sciences.advisory_details.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'student_enrollment' => 'required|exists:students,enrollment',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'required|string|max:15',
            'observations' => 'nullable|string|max:100',
        ]);

        $detail = Advisory_details::create($validated);

        return redirect()->route('basic_sciences.advisories.create', ['detail.id' => $detail->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisory_details $advisory_details)
    {
        //
    }
}
