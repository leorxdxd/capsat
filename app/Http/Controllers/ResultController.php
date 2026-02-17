<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\ExamAttempt;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

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
            ->whereIn('status', ['draft', 'returned', 'counselor_approved'])
            ->latest()
            ->get()
            ->unique('student_id');
            
        return view('results.index', compact('results'));
    }
    
    /**
     * Show result details for review
     */
    public function show(ExamResult $result)
    {
        $result->load(['student', 'exam', 'signatures.user']);

        // Calculate precise age at time of exam using new helper
        $ageData = $result->student->getAgeDecomposed($result->created_at);
        $ageYears = $ageData['years'];
        $ageMonths = $ageData['months'];

        // Fetch precise norm data
        $normData = null;
        $normTable = \App\Models\NormTable::where('exam_id', $result->exam_id)->first();
        
        if ($normTable) {
            $normRange = $normTable->findNormRange($ageYears, $ageMonths, (int)$result->raw_score);
            
            if ($normRange) {
                $normData = $normRange;
                
                // Auto-fill if missing (legacy support)
                if (!$result->performance_description || !$result->percentile) {
                    $result->update([
                        'performance_description' => $normRange->description,
                        'percentile' => $normRange->percentile,
                    ]);
                    $result->refresh();
                }
            }
        }

        // Fetch ALL results for this student to display in the profile table
        $allResults = ExamResult::with('exam')
            ->where('student_id', $result->student_id)
            ->latest()
            ->get();

        return view('results.show', compact('result', 'normData', 'ageYears', 'ageMonths', 'allResults'));
    }
    
    /**
     * Send result to counselor for review
     */
    public function sendToCounselor(Request $request, ExamResult $result)
    {
        $validated = $request->validate([
            'psychometrician_notes' => 'nullable|string',
            'recommendation' => 'required|string',
        ]);
        
        $result->update([
            'psychometrician_notes' => $request->psychometrician_notes,
            'recommendation' => $request->recommendation,
        ]);

        // Add Psychometrician Signature if not exists
        if (!$result->signatures()->where('role', 'psychometrician')->exists()) {
             $result->signatures()->create([
                'user_id' => auth()->id(),
                'role' => 'psychometrician',
                'signed_at' => now(),
            ]);
        }
        
        $result->sendToCounselor();
        
        // Notify Counselors
        $counselors = \App\Models\User::whereHas('role', function ($query) {
            $query->where('slug', 'counselor');
        })->get();
        Notification::send($counselors, new SystemNotification(
            'New exam result pending review for ' . $result->student->full_name,
            route('counselor.show', $result->id),
            'info'
        ));
        
        return redirect()->route('results.index')
            ->with('success', 'Result signed and sent to counselor for review.');
    }
    
    /**
     * View PDF preview
     */
    public function viewPdf(ExamResult $result)
    {
        // Allow staff to print drafts for signing/review
        if (!$result->canBePrinted() && !auth()->user()->hasAnyRole(['psychometrician', 'counselor', 'admin'])) {
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
        // Allow staff to print drafts for signing/review
        if (!$result->canBePrinted() && !auth()->user()->hasAnyRole(['psychometrician', 'counselor', 'admin'])) {
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
        
        // Allow final edits and mark as official
        $result->update([
            'psychometrician_notes' => $request->input('psychometrician_notes'),
            'recommendation' => $request->input('recommendation'),
        ]);

        $result->markAsOfficial();
        
        // Notify Student
        $result->student->user->notify(new SystemNotification(
            'Your exam result has been released.',
            route('student.exams.result', $result->exam_attempt_id),
            'success'
        ));

        return redirect()->route('results.index')
            ->with('success', 'Result finalized and ready for printing.');
    }

    /**
     * List retake requests (Psychometrician)
     */
    public function indexRetakeRequests()
    {
        $requests = ExamAttempt::whereNotNull('retake_requested_at')
            // ->whereNull('deleted_at') // implicit with SoftDeletes
            ->with(['user.student', 'exam'])
            ->orderBy('retake_requested_at', 'asc') // oldest first
            ->get();
            
        return view('results.retake-requests', compact('requests'));
    }

    /**
     * Approve a retake request
     */
    public function approveRetake(Request $request, ExamAttempt $attempt)
    {
        // Delete the result first if it exists
        // (Since result doesn't have SoftDeletes yet, we force delete it to clear the record)
        if ($attempt->examResult) {
            $attempt->examResult->delete();
        }

        // Soft delete the attempt to archive it
        $attempt->delete();
        
        // Notify Student
        $attempt->user->notify(new SystemNotification(
            'Your retake request for ' . $attempt->exam->title . ' has been approved.',
            route('student.exams.show', $attempt->exam_id),
            'success'
        ));

        return back()->with('success', 'Retake approved. The student can now start a new attempt.');
    }
}
