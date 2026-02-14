<?php

namespace App\Http\Controllers;

use App\Models\NormTable;
use App\Models\NormRange;
use App\Models\Exam;
use Illuminate\Http\Request;

class NormTableController extends Controller
{
    /**
     * Display a listing of norm tables
     */
    public function index()
    {
        $normTables = NormTable::with('exam')->latest()->get();
        return view('norms.index', compact('normTables'));
    }

    /**
     * Show the form for creating a new norm table
     */
    public function create()
    {
        $exams = Exam::all();
        return view('norms.create', compact('exams'));
    }

    /**
     * Store a newly created norm table
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $normTable = NormTable::create($validated);

        return redirect()->route('norms.show', $normTable)
            ->with('success', 'Norm table created successfully. Now add interpretation ranges.');
    }

    /**
     * Display the specified norm table with all ranges
     */
    public function show(NormTable $norm)
    {
        $norm->load(['exam', 'normRanges' => function($query) {
            $query->orderBy('min_age')->orderBy('min_score');
        }]);
        
        return view('norms.show', compact('norm'));
    }

    /**
     * Show the form for editing the specified norm table
     */
    public function edit(NormTable $norm)
    {
        $exams = Exam::all();
        return view('norms.edit', compact('norm', 'exams'));
    }

    /**
     * Update the specified norm table
     */
    public function update(Request $request, NormTable $norm)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $norm->update($validated);

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Norm table updated successfully.');
    }

    /**
     * Remove the specified norm table
     */
    public function destroy(NormTable $norm)
    {
        $norm->delete();

        return redirect()->route('norms.index')
            ->with('success', 'Norm table deleted successfully.');
    }

    /**
     * Add a new norm range to the table
     */
    public function addRange(Request $request, NormTable $norm)
    {
        $validated = $request->validate([
            'min_age' => 'required|numeric|min:0',
            'max_age' => 'required|numeric|gt:min_age',
            'min_score' => 'required|integer|min:0',
            'max_score' => 'required|integer|gt:min_score',
            'percentile' => 'nullable|integer|min:0|max:100',
            'description' => 'required|string|max:255',
        ]);

        $validated['norm_table_id'] = $norm->id;
        NormRange::create($validated);

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Interpretation range added successfully.');
    }

    /**
     * Delete a norm range
     */
    public function deleteRange(NormTable $norm, NormRange $range)
    {
        if ($range->norm_table_id !== $norm->id) {
            abort(403, 'This range does not belong to this norm table.');
        }

        $range->delete();

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Interpretation range deleted successfully.');
    }
}
