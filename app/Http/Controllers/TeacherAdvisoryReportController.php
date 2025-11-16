<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\AdvisoryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function listByAdvisory($id)
{
    $advisory = Advisories::with('teacherSubject.subject')->findOrFail($id);

    $reports = AdvisoryReport::where('advisory_id', $id)->get();

    return view('teachers.advisories.reports.by_advisory', compact('advisory', 'reports'));
}

public function edit($id)
{
    $report = AdvisoryReport::with('advisory.teacherSubject.subject')->findOrFail($id);

    return view('teachers.advisories.reports.edit', compact('report'));
}

public function update(Request $request, $id)
{
    $report = AdvisoryReport::findOrFail($id);

    $request->validate([
        'report_type' => 'required|in:previo,final',
        'file'        => 'nullable|file|mimes:pdf,doc,docx|max:4096',
    ]);

    // Actualizar tipo de reporte
    $report->report_type = $request->report_type;

    // Si sube nuevo archivo, reemplazar
    if ($request->hasFile('file')) {
        // opcional: borrar el anterior
        if ($report->file_path && \Storage::disk('public')->exists($report->file_path)) {
            \Storage::disk('public')->delete($report->file_path);
        }

        $path = $request->file('file')->store('reports', 'public');
        $report->file_path = $path;
    }

    $report->save();

    // 👈 AQUÍ ESTABA EL PROBLEMA
    return redirect()
        ->route('teachers.advisories.reports.index', $report->advisory_id)
        ->with('success', 'Reporte actualizado correctamente.');
}


public function destroy($id)
{
    $report = AdvisoryReport::findOrFail($id);

    $advisoryId = $report->advisory_id; // lo guardamos antes de borrar

    // Borrar archivo físico si existe
    if ($report->file_path && \Storage::disk('public')->exists($report->file_path)) {
        \Storage::disk('public')->delete($report->file_path);
    }

    $report->delete();

    // 👈 Igual, redirigimos pasando el advisory_id
    return redirect()
        ->route('teachers.advisories.reports.index', $advisoryId)
        ->with('success', 'Reporte eliminado correctamente.');
}



}
