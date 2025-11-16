<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\AdvisoryReport;
use Illuminate\Http\Request;

class TeacherAdvisoryReportController extends Controller
{
    public function index()
{
    $user = auth()->user()->user;

    $reports = AdvisoryReport::whereHas('advisory.teacherSubject', function($q) use ($user) {
        $q->where('teacher_user', $user);
    })->get();

    return view('teachers.advisories.reports.index', compact('reports'));
}

public function edit($id)
{
    $report = AdvisoryReport::findOrFail($id);

    return view('teachers.advisories.reports.edit', compact('report'));
}

public function update(Request $request, $id)
{
    $report = AdvisoryReport::findOrFail($id);

    $request->validate([
        'file' => 'required|mimes:pdf,doc,docx|max:4096',
    ]);

    $fileName = time() . '_' . $request->file->getClientOriginalName();
    $request->file->storeAs('reports', $fileName, 'public');

    // Borrar archivo anterior
    if ($report->file && file_exists(storage_path('app/public/reports/'.$report->file))) {
        unlink(storage_path('app/public/reports/'.$report->file));
    }

    $report->update([
        'file' => $fileName
    ]);

    return redirect()->route('teachers.advisories.reports.index')
        ->with('success', 'Reporte actualizado correctamente');
}

        public function create($advisory_id)
    {
        $advisory = Advisories::with(['teacherSubject.teacher', 'advisoryDetail.students'])
            ->findOrFail($advisory_id);

        return view('teachers.advisories.reports.create', compact('advisory'));
    }

    public function store(Request $request, $advisory_id)
    {
        $advisory = Advisories::findOrFail($advisory_id);

        $request->validate([
            'report_type' => 'required|in:previo,final',
            'file'        => 'required|file|mimes:pdf,doc,docx|max:4096',
        ]);

        // guardar archivo
        $path = $request->file('file')->store('reports', 'public');

        // registrar reporte
        AdvisoryReport::create([
            'advisory_id' => $advisory->advisory_id,
            'report_type' => $request->report_type,
            'file_path'   => $path,
        ]);

        return redirect()
            ->route('teachers.advisories.index')
            ->with('success', 'Reporte guardado correctamente.');
    }
}
