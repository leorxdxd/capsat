<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\ExamAttempt;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResultController extends Controller
{
    protected $resultService;
    
    public function __construct(ResultService $resultService)
    {
        $this->resultService = $resultService;
    }
    
    /**
     * List all results pending psychometrician review
     */
    public function index()
    {
        $results = ExamResult::with(['student', 'exam'])
            ->whereIn('status', ['draft', 'returned'])
            ->latest()
            ->get();
            
        return view('results.index', compact('results'));
    }
    
    /**
     * Show result details for review
     */
    public function show(ExamResult $result)
    {
        $result->load(['student', 'exam', 'signatures.user']);
        return view('results.show', compact('result'));
    }
    
    /**
     * Send result to counselor for review
     */
    public function sendToCounselor(Request $request, ExamResult $result)
    {
        $validated = $request->validate([
            'psychometrician_notes' => 'nullable|string',
            'recommendation' => 'nullable|string',
        ]);
        
        $result->update($validated);
        $result->sendToCounselor();
        
        return redirect()->route('results.index')
            ->with('success', 'Result sent to counselor for review.');
    }
    
    /**
     * View PDF preview
     */
    public function viewPdf(ExamResult $result)
    {
        if (!$result->canBePrinted()) {
            return back()->with('error', 'Result must have both signatures before printing.');
        }

        $result->load(['student', 'exam', 'signatures.user']);
        $pdf = Pdf::loadView('reports.result-pdf', compact('result'));
        
        return $pdf->stream('result-' . $result->id . '.pdf');
    }

    /**
     * Download PDF
     */
    public function downloadPdf(ExamResult $result)
    {
        if (!$result->canBePrinted()) {
            return back()->with('error', 'Result must have both signatures before printing.');
        }

        $result->load(['student', 'exam', 'signatures.user']);
        $pdf = Pdf::loadView('reports.result-pdf', compact('result'));
        
        $filename = 'Entrance_Exam_Result_' . $result->student->last_name . '_' . $result->id . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Final sign after counselor approval
     */
    public function finalSign(Request $request, ExamResult $result)
    {
        if (!$result->hasCounselorSignature()) {
            return back()->with('error', 'Counselor must sign first.');
        }
        
        $this->resultService->signResult(
            $result,
            auth()->user(),
            'psychometrician',
            $request->input('comments')
        );
        
        return redirect()->route('results.index')
            ->with('success', 'Result finalized and ready for printing.');
    }
}
