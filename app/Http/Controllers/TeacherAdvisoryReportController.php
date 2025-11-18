<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\AdvisoryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherAdvisoryReportController extends Controller
{
    /**
     * Mostrar todos los reportes del maestro.
     */
    public function index()
    {
        $user = auth()->user()->user;

        $reports = AdvisoryReport::whereHas('advisory.teacherSubject', function($q) use ($user) {
            $q->where('teacher_user', $user);
        })->get();

        return view('teachers.advisories.reports.index', compact('reports'));
    }

    /**
     * Crear reporte nuevo para una asesoría.
     */
    public function create($advisory_id)
    {
        $advisory = Advisories::with(['teacherSubject.teacher', 'advisoryDetail.students'])
            ->findOrFail($advisory_id);

        return view('teachers.advisories.reports.create', compact('advisory'));
    }

    /**
     * Guardar reporte.
     */
    public function store(Request $request, $advisory_id)
    {
        $advisory = Advisories::findOrFail($advisory_id);

        $request->validate([
            'report_type' => 'required|in:previo,final',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:4096',
        ]);

        $file = $request->file('file');
        $origName = $file->getClientOriginalName();
        $filename = $origName;
        $dir = "reports";

        // Evitar nombres duplicados
        $counter = 1;
        while (Storage::disk('public')->exists("$dir/$filename")) {
            $filename = pathinfo($origName, PATHINFO_FILENAME)
                      . "_$counter."
                      . $file->getClientOriginalExtension();
            $counter++;
        }

        $path = $file->storeAs($dir, $filename, 'public');

        AdvisoryReport::create([
            'advisory_id' => $advisory->advisory_id,
            'report_type' => $request->report_type,
            'file_path'   => $path,
        ]);

        return redirect()
            ->route('teachers.advisories.index')
            ->with('success', 'Reporte creado correctamente.');
    }

    /**
     * Ver lista de reportes según la asesoría seleccionada.
     */
    public function listByAdvisory($id)
    {
        $advisory = Advisories::with('teacherSubject.subject')
            ->findOrFail($id);

        $reports = AdvisoryReport::where('advisory_id', $id)->get();

        return view('teachers.advisories.reports.by_advisory', compact('advisory', 'reports'));
    }

    /**
     * Editar reporte.
     */
    public function edit($id)
    {
        $report = AdvisoryReport::with('advisory.teacherSubject.subject')
            ->findOrFail($id);

        return view('teachers.advisories.reports.edit', compact('report'));
    }

    /**
     * Actualizar reporte.
     */
    public function update(Request $request, $id)
    {
        $report = AdvisoryReport::findOrFail($id);

        $request->validate([
            'report_type' => 'required|in:previo,final',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:4096',
        ]);

        $report->report_type = $request->report_type;

        if ($request->hasFile('file')) {

            // Eliminar archivo anterior
            if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
                Storage::disk('public')->delete($report->file_path);
            }

            $file = $request->file('file');
            $origName = $file->getClientOriginalName();
            $filename = $origName;
            $dir = "reports";

            $counter = 1;
            while (Storage::disk('public')->exists("$dir/$filename")) {
                $filename = pathinfo($origName, PATHINFO_FILENAME)
                          . "_$counter."
                          . $file->getClientOriginalExtension();
                $counter++;
            }

            $path = $file->storeAs($dir, $filename, 'public');
            $report->file_path = $path;
        }

        $report->save();

        return redirect()
            ->route('teachers.advisories.reports.by_advisory', $report->advisory_id)
            ->with('success', 'Reporte actualizado correctamente.');
    }

    /**
     * Eliminar reporte.
     */
    public function destroy($id)
    {
        $report = AdvisoryReport::findOrFail($id);
        $advisoryId = $report->advisory_id;

        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        $report->delete();

        return redirect()
            ->route('teachers.advisories.reports.by_advisory', $advisoryId)
            ->with('success', 'Reporte eliminado correctamente.');
    }
}
