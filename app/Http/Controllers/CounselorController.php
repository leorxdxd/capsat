<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Services\ResultService;
use Illuminate\Http\Request;

class CounselorController extends Controller
{
    protected $resultService;
    
    public function __construct(ResultService $resultService)
    {
        $this->resultService = $resultService;
    }
    
    /**
     * List results pending counselor review
     */
    public function index()
    {
        $results = ExamResult::with(['student', 'exam'])
            ->where('status', 'for_counselor')
            ->latest()
            ->get();
            
        return view('counselor.index', compact('results'));
    }
    
    /**
     * Show result for counselor review
     */
    public function show(ExamResult $result)
    {
        $result->load(['student', 'exam', 'signatures.user']);
        return view('counselor.show', compact('result'));
    }
    
    /**
     * Approve and sign result
     */
    public function approve(Request $request, ExamResult $result)
    {
        $validated = $request->validate([
            'counselor_notes' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);
        
        $result->update($validated);
        
        $this->resultService->signResult(
            $result,
            auth()->user(),
            'counselor',
            $request->input('comments')
        );
        
        return redirect()->route('counselor.index')
            ->with('success', 'Result approved and signed. Returned to psychometrician for final signature.');
    }
    
    /**
     * Return result to psychometrician with reason
     */
    public function return(Request $request, ExamResult $result)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);
        
        $result->returnToPsychometrician($validated['rejection_reason']);
        
        return redirect()->route('counselor.index')
            ->with('success', 'Result returned to psychometrician for revision.');
    }
}
