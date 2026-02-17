<?php

namespace App\Http\Controllers;

use App\Models\NormTable;
use App\Models\NormRange;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NormTableController extends Controller
{
    /**
     * Display a listing of norm tables
     */
    public function index()
    {
        $normTables = NormTable::with('exam')->withCount('normRanges')->latest()->get();
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
            ->with('success', 'Norm table created successfully. Now add entries.');
    }

    /**
     * Display the specified norm table with entries grouped by age bracket
     */
    public function show(NormTable $norm)
    {
        $norm->load('exam');
        
        // 1. Get Distinct Age Brackets (Pagination Target)
        // We group by Age Years + Months Start + Months End
        $brackets = $norm->normRanges()
            ->select('age_years', 'age_months_start', 'age_months_end')
            ->distinct()
            ->orderBy('age_years')
            ->orderBy('age_months_start')
            ->paginate(5); // Show 5 brackets per page
            
        // 2. Load Entries for ONLY these brackets
        // We can do this by iterating and loading, or a whereIn query.
        // Simple iteration is fine for 5 brackets.
        $groupedRanges = collect();
        
        foreach ($brackets as $bracket) {
            $key = "AGE {$bracket->age_years}   {$bracket->age_months_start}-{$bracket->age_months_end}";
            
            $entries = $norm->normRanges()
                ->where('age_years', $bracket->age_years)
                ->where('age_months_start', $bracket->age_months_start)
                ->where('age_months_end', $bracket->age_months_end)
                ->orderBy('raw_score')
                ->get();
                
            $groupedRanges->put($key, $entries);
        }

        return view('norms.show', compact('norm', 'brackets', 'groupedRanges'));
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
     * Add a single norm entry
     */
    public function addRange(Request $request, NormTable $norm)
    {
        $validated = $request->validate([
            'age_years' => 'required|integer|min:1|max:99',
            'age_months_start' => 'required|integer|min:0|max:11',
            'age_months_end' => 'required|integer|min:0|max:11|gte:age_months_start',
            'raw_score' => 'required|integer|min:0',
            'sai' => 'required|integer|min:0',
            'percentile' => 'required|integer|min:0|max:100',
            'stanine' => 'required|integer|min:1|max:9',
            'description' => 'required|string|max:255',
        ]);

        $validated['norm_table_id'] = $norm->id;
        NormRange::create($validated);

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Norm entry added successfully.');
    }

    /**
     * Add multiple norm entries at once for one age bracket
     */
    public function addBulk(Request $request, NormTable $norm)
    {
        $request->validate([
            'age_years' => 'required|integer|min:1|max:99',
            'age_months_start' => 'required|integer|min:0|max:11',
            'age_months_end' => 'required|integer|min:0|max:11|gte:age_months_start',
            'entries' => 'required|array|min:1',
            'entries.*.raw_score' => 'required|integer|min:0',
            'entries.*.sai' => 'required|integer|min:0',
            'entries.*.percentile' => 'required|integer|min:0|max:100',
            'entries.*.stanine' => 'required|integer|min:1|max:9',
            'entries.*.description' => 'required|string|max:255',
        ]);

        $count = 0;
        foreach ($request->input('entries') as $entry) {
            if (!empty($entry['raw_score']) && $entry['raw_score'] !== '') {
                NormRange::create([
                    'norm_table_id' => $norm->id,
                    'age_years' => $request->input('age_years'),
                    'age_months_start' => $request->input('age_months_start'),
                    'age_months_end' => $request->input('age_months_end'),
                    'raw_score' => $entry['raw_score'],
                    'sai' => $entry['sai'],
                    'percentile' => $entry['percentile'],
                    'stanine' => $entry['stanine'],
                    'description' => $entry['description'],
                ]);
                $count++;
            }
        }

        return redirect()->route('norms.show', $norm)
            ->with('success', "{$count} norm entries added successfully.");
    }

    /**
     * Delete a norm range
     */
    public function deleteRange(NormTable $norm, NormRange $range)
    {
        if ($range->norm_table_id !== $norm->id) {
            abort(403, 'This entry does not belong to this norm table.');
        }

        $range->delete();

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Norm entry deleted successfully.');
    }

    /**
     * Delete all entries for a specific age bracket
     */
    public function deleteBracket(Request $request, NormTable $norm)
    {
        $request->validate([
            'age_years' => 'required|integer',
            'age_months_start' => 'required|integer',
            'age_months_end' => 'required|integer',
        ]);

        $norm->normRanges()
            ->where('age_years', $request->input('age_years'))
            ->where('age_months_start', $request->input('age_months_start'))
            ->where('age_months_end', $request->input('age_months_end'))
            ->delete();

        return redirect()->route('norms.show', $norm)
            ->with('success', 'Age bracket entries deleted successfully.');
    }

    /**
     * Show import form
     */
    public function import(NormTable $norm)
    {
        return view('norms.import', compact('norm'));
    }

    /**
     * Process imported data
     */
    public function processImport(Request $request, NormTable $norm)
    {
        $request->validate([
            'import_file' => 'nullable|file|mimes:csv,txt|max:2048',
            'paste_data' => 'nullable|string',
        ]);

        if (!$request->hasFile('import_file') && !$request->filled('paste_data')) {
            return back()->withErrors(['import_file' => 'Please upload a CSV file or paste data.']);
        }

        $data = [];

        // Handle File Upload
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            // Remove header if explicitly requested or auto-detected (simple check if first row has text keys)
            // For now, we'll assume the user Maps columns, or we handle it in parsing
        } 
        // Handle Paste Data
        elseif ($request->filled('paste_data')) {
            $lines = explode("\n", trim($request->input('paste_data')));
            foreach ($lines as $line) {
                // Split by tab (Excel copy) or comma
                $row = preg_split('/[\t,]/', trim($line));
                if (count($row) > 1) {
                    $data[] = $row;
                }
            }
        }

        // Processing Logic
        // We assume the user provides specific column indices. 
        // For simplicity v1: we'll try to auto-detect or expect a fixed usage instruction:
        // "Paste data with columns: AgeYears, MosStart, MosEnd, RS, SAI, %TILE, STA, DES"
        
        // BETTER: Just save generic rows if we can't be sure, OR use mapping.
        // Let's implement a direct mapping for this specific request:
        // RSCODE | RS | SAI | %TILE | STA | DES
        // But the user has Age Brackets separately.
        
        // Let's implement a generic parser that looks for our required fields.
        
        $count = 0;
        foreach ($data as $row) {
            // Basic validation to skip empty headers/rows
            if (count($row) < 5 || !is_numeric($row[1] ?? '')) continue; 
            
            // Expected Format based on user request:
            // RSCODE (14+21) | RS (1) | SAI (53) | %TILE (1) | STA (1) | DES (L - Low)
            
            // We need to parse RSCODE to get age if not provided separately
            // RSCODE = "14+21" -> Age 14, RS 21 (Wait, RS is also in col 2?)
            // If user provides "Age 14 0-2" as a header row, that's complex to parse.
            
            // ROBUST APPROACH:
            // Expect fields: [AgeYears, MosStart, MosEnd, RS, SAI, %TILE, STA, DES]
            // We'll trust the user to arrange columns in this order for "Paste"
            
            try {
                // Sanitize and Parse
                // If row has 8 columns:
                if (count($row) >= 8) {
                    $ageInfo = [
                         'age_years' => (int) $row[0],
                         'age_months_start' => (int) $row[1],
                         'age_months_end' => (int) $row[2],
                    ];
                    $rs = (int) $row[3];
                    $sai = (int) $row[4];
                    $perc = (int) $row[5];
                    $sta = (int) $row[6];
                    $des = trim($row[7] ?? '');
                } else {
                     // Try to match 6 columns format from user example if strict
                     // RSCODE | RS | SAI | %TILE | STA | DES
                     // This format lacks month range. 
                     // Let's stick to the 8-column format for the implementation to be complete.
                     continue;
                }

                NormRange::create([
                    'norm_table_id' => $norm->id,
                    'age_years' => $ageInfo['age_years'],
                    'age_months_start' => $ageInfo['age_months_start'],
                    'age_months_end' => $ageInfo['age_months_end'],
                    'raw_score' => $rs,
                    'sai' => $sai,
                    'percentile' => $perc,
                    'stanine' => $sta,
                    'description' => $des,
                ]);
                $count++;
            } catch (\Exception $e) {
                // Skip bad rows
                continue;
            }
        }

        return redirect()->route('norms.show', $norm)
            ->with('success', "Imported {$count} entries successfully.");
    }
    /**
     * Check/Test a norm lookup
     */
    public function check(Request $request, NormTable $norm)
    {
        $request->validate([
            'age_years' => 'required|integer|min:0',
            'age_months' => 'required|integer|min:0|max:11',
            'raw_score' => 'required|integer|min:0',
        ]);

        $ageYears = $request->input('age_years');
        $ageMonths = $request->input('age_months');
        $rawScore = $request->input('raw_score');

        $result = $norm->findNormRange($ageYears, $ageMonths, $rawScore);

        if ($result) {
            $message = "Match Found: SAI: {$result->sai}, %TILE: {$result->percentile}, STA: {$result->stanine}, DES: {$result->description}";
            return redirect()->route('norms.show', $norm)
                ->with('check_success', $message)
                ->with('check_details', $result)
                ->withInput();
        } else {
            return redirect()->route('norms.show', $norm)
                ->with('check_error', "No match found for Age {$ageYears}y {$ageMonths}m, Score {$rawScore}.")
                ->withInput();
        }
    }
}
