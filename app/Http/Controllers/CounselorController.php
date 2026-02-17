<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Services\ResultService;
use Illuminate\Http\Request;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

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

        $stats = [
            'pending' => $results->count(),
            'approved' => ExamResult::where('status', 'counselor_approved')->count(),
            'total_reviewed' => \App\Models\ResultSignature::where('role', 'counselor')->count()
        ];
            
        return view('counselor.reviews', compact('results', 'stats'));
    }

    public function history()
    {
        $results = ExamResult::with(['student', 'exam'])
            ->whereHas('signatures', function($query) {
                $query->where('user_id', auth()->id())
                      ->where('role', 'counselor');
            })
            ->latest()
            ->get();
            
        return view('counselor.history', compact('results'));
    }
    
    /**
     * Show result for counselor review
     */
    public function show(ExamResult $result)
    {
        $result->load(['student', 'exam', 'signatures.user']);
        
        // Authorization: Only view if pending for counselor OR signed by this counselor
        $hasSigned = $result->signatures()->where('user_id', auth()->id())->where('role', 'counselor')->exists();
        if ($result->status !== 'for_counselor' && !$hasSigned) {
            abort(403, 'You are not authorized to view this result.');
        }

        // Auto-fill interpretation if missing but norm table exists
        if (!$result->performance_description || !$result->percentile) {
            $normTable = \App\Models\NormTable::where('exam_id', $result->exam_id)->first();
            if ($normTable) {
                $normRange = $normTable->findNormRange($result->age_years, $result->age_months, (int)$result->raw_score);
                if ($normRange) {
                    $result->update([
                        'performance_description' => $normRange->description,
                        'percentile' => $normRange->percentile,
                    ]);
                    $result->refresh();
                }
            }
        }

        return view('counselor.show', compact('result'));
    }
    
    /**
     * Approve and sign result
     */
    public function approve(Request $request, ExamResult $result)
    {
        $validated = $request->validate([
            'counselor_notes' => 'required|string',
        ]);
        
        $result->update([
            'counselor_notes' => $validated['counselor_notes'],
        ]);
        
        $this->resultService->signResult(
            $result,
            auth()->user(),
            'counselor',
            // We use counselor_notes above, signResult comments field is optional/duplicate
            // We can pass null or the same notes if we want them in signatures table too
            $validated['counselor_notes'] 
        );
        
        // Notify Psychometricians
        $psychometricians = \App\Models\User::whereHas('role', function ($query) {
            $query->where('slug', 'psychometrician');
        })->get();
        Notification::send($psychometricians, new SystemNotification(
            'Counselor approved result for ' . $result->student->full_name,
            route('results.show', $result->id),
            'success'
        ));

        return redirect()->route('counselor.index')
            ->with('success', 'Result approved and signed. Returned to Psychometrician for finalization.');
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
        
        // Notify Psychometricians
        $psychometricians = \App\Models\User::whereHas('role', function ($query) {
            $query->where('slug', 'psychometrician');
        })->get();
        Notification::send($psychometricians, new SystemNotification(
            'Counselor returned result for ' . $result->student->full_name,
            route('results.show', $result->id),
            'warning'
        ));

        return redirect()->route('counselor.index')
            ->with('success', 'Result returned to psychometrician for revision.');
    }
}
