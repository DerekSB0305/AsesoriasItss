<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Career;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $career = $request->career;

        $query = Subject::with('career');


        if ($search) {
            $query->where('name', 'LIKE', "%$search%");
        }


        if ($career === 'comun') {
            $query->whereNull('career_id');
        } elseif ($career) {
            $query->where('career_id', $career);
        }

        // Obtener materias paginadas
        $subjects = $query->orderBy('name')->paginate(15);


        $careers = Career::orderBy('name')->get();

        return view('basic_sciences.subjects.index', compact(
            'subjects',
            'careers',
            'search',
            'career'
        ));
    }


    public function create()
    {
        $careers = Career::orderBy('name')->get();
        return view('basic_sciences.subjects.create', compact('careers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100|unique:subjects,name',
            'type'      => 'nullable|string|max:50',
            'career_id' => 'nullable|exists:careers,career_id',
            'period'    => 'nullable|string|max:50',
        ]);

        Subject::create([
            'name'      => $request->name,
            'type'      => $request->type,
            'career_id' => $request->career_id,
            'period'    => $request->period,
        ]);

        return redirect()->route('basic_sciences.subjects.index')
            ->with('success', 'Materia registrada correctamente.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $careers = Career::orderBy('name')->get();

        return view('basic_sciences.subjects.edit', compact('subject', 'careers'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:100|unique:subjects,name,' . $subject->subject_id . ',subject_id',
            'type'      => 'nullable|string|max:50',
            'period'    => 'nullable|string|max:50',
            'career_id' => 'nullable|exists:careers,career_id',
        ]);

        $subject->update([
            'name'      => $request->name,
            'type'      => $request->type,
            'period'    => $request->period,
            'career_id' => $request->career_id,
        ]);

        return redirect()->route('basic_sciences.subjects.index')
            ->with('success', 'Materia actualizada correctamente.');
    }
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('basic_sciences.subjects.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}
