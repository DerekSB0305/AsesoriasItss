<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Container\Attributes\Storage as AttributesStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents =Document::all();
        return view('basic_sciences.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('basic_sciences.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'name' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
    ]);

    if ($request->hasFile('file')) {

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Si el archivo ya existe, agrega un sufijo único
        $safeName = time() . '_' . $originalName;

        // Guardar con nombre original (con prefijo para evitar conflictos)
        $path = $file->storeAs('documents', $safeName, 'public');

        Document::create([
            'name' => $request->name,
            'file_path' => $path,
        ]);
    }

    return redirect()->route('basic_sciences.documents.index')
        ->with('success', 'Documento subido correctamente.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
         if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Documento eliminado correctamente.');
    }

    }


