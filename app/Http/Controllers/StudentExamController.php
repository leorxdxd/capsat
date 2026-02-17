<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Authorization;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\ResultService;

class StudentExamController extends Controller
{
    protected $resultService;

    public function __construct(ResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    /**
     * List available exams for the student
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('my-profile.edit')
                ->with('warning', 'Please complete your student profile first before accessing exams.');
        }

        // Get exams targeting the student's grade level or all grades
        // And check if they are active
        $exams = Exam::where('active', true)
            ->where(function($q) use ($student) {
                $q->where('target_grade_level', $student->current_grade_level)
                  ->orWhereNull('target_grade_level');
            })
            ->get();

        // Load attempts for these exams to show status
        $attempts = ExamAttempt::where('user_id', $user->id)
            ->whereIn('exam_id', $exams->pluck('id'))
            ->get()
            ->keyBy('exam_id');

        return view('student.exams.index', compact('exams', 'attempts'));
    }

    /**
     * Show exam instructions / start page
     */
    public function show(Exam $exam)
    {
        // specific check if exam is allowed for this student
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('my-profile.edit')
                ->with('warning', 'Please complete your student profile first.');
        }

        if ($exam->target_grade_level && $exam->target_grade_level !== $student->current_grade_level) {
            abort(403, 'This exam is not available for your grade level.');
        }

        // Check if already taken
        $existingAttempt = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->first();

        return view('student.exams.show', compact('exam', 'existingAttempt'));
    }

    /**
     * Start the exam
     */
    public function start(Request $request, Exam $exam)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('my-profile.edit')
                ->with('warning', 'Please complete your student profile first.');
        }

        // Check if already started or completed
        $attempt = ExamAttempt::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'exam_id' => $exam->id
            ],
            [
                'status' => 'in_progress',
                'started_at' => now(),
            ]
        );

        return redirect()->route('student.exams.take', $attempt);
    }

    /**
     * Take the exam (the actual question interface)
     */
    public function take(ExamAttempt $attempt)
    {
        // Ensure this attempt belongs to user
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // If completed, redirect to show/result
        if ($attempt->status === 'completed') {
            return redirect()->route('student.exams.show', $attempt->exam);
        }

        $exam = $attempt->exam;
        $exam->load(['sections.questions' => function($q) {
            $q->orderBy('id');
        }]);

        // Calculate remaining time
        $remainingSeconds = null;
        if ($exam->time_limit && $exam->time_limit > 0) {
            $elapsed = now()->diffInSeconds($attempt->started_at);
            $remainingSeconds = max(0, ($exam->time_limit * 60) - $elapsed);
        }

        return view('student.exams.take', compact('attempt', 'exam', 'remainingSeconds'));
    }

    /**
     * Submit exam answers
     */
    public function submit(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($attempt->status === 'completed') {
             return redirect()->route('results.show', $attempt->exam_result->id ?? null);
        }

        $answers = $request->input('answers', []);
        
        DB::transaction(function () use ($attempt, $answers) {
            $totalScore = 0;
            $maxScore = 0;
            
            // Fetch all questions to verify answers
            $questions = Question::whereIn('section_id', $attempt->exam->sections->pluck('id'))->get()->keyBy('id');

            foreach ($answers as $questionId => $userAnswer) {
                if ($question = $questions->get($questionId)) {
                    $isCorrect = false;
                    $pointsObj = 0;

                    // Smart Scoring
                    $normalizedUser = trim($userAnswer);
                    $normalizedCorrect = trim($question->correct_answer);
                    
                    // 1. Exact Match (Case-insensitive)
                    if (strcasecmp($normalizedUser, $normalizedCorrect) === 0) {
                        $isCorrect = true;
                        $pointsObj = $question->points;
                    } 
                    // 2. Key Extraction (e.g. User="A. 2", Correct="A")
                    // Matches "A. ", "a) ", etc.
                    elseif (preg_match('/^([A-Z])[\.\)]\s/i', $normalizedUser, $matches)) {
                        if (strcasecmp($matches[1], $normalizedCorrect) === 0) {
                            $isCorrect = true;
                            $pointsObj = $question->points;
                        }
                    }

                    Answer::updateOrCreate(
                        ['exam_attempt_id' => $attempt->id, 'question_id' => $questionId],
                        ['answer' => $userAnswer, 'is_correct' => $isCorrect, 'points_awarded' => $pointsObj]
                    );

                    $totalScore += $pointsObj;
                }
            }

            $attempt->update([
                'status' => 'completed',
                'submitted_at' => now(),
                'raw_score' => $totalScore
                // We'll calculate percentage/result logic in ResultService or here if simple
            ]);
            
            // Create ExamResult entry immediately? 
            // Usually result processing happens here or separate. 
            // For now let's just create a basic result record if needed or redirect.
            // The ResultController usually handles generating the full report.
            
            // NEW: Generate proper result using centralized Service
            $this->resultService->generateResult($attempt);
        });

        // Redirect to a result summary
        return redirect()->route('student.exams.result', $attempt->id);
    }

    /**
     * Show the result of a completed exam attempt.
     */
    public function showResult(ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        if ($attempt->status !== 'completed') {
            return redirect()->route('student.exams.take', $attempt)->with('error', 'Exam not yet completed.');
        }

        $result = $attempt->examResult;
        if (!$result) {
            abort(404, 'Exam result not found.');
        }

        $exam = $attempt->exam;
        $answers = $attempt->answers()->with('question')->get();

        return view('student.exams.result', compact('attempt', 'result', 'exam', 'answers'));
    }

    /**
     * Request a retake for a completed exam
     */
    public function requestRetake(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($attempt->status !== 'completed') {
            return back()->with('error', 'Only completed exams can be retaken.');
        }
        
        if ($attempt->retake_requested_at) {
            return back()->with('error', 'Retake already requested.');
        }
        
        $attempt->update([
            'retake_requested_at' => now(),
            'retake_reason' => $request->input('reason'),
        ]);
        
        // Notify Psychometricians
        $psychometricians = \App\Models\User::whereHas('role', function ($query) {
            $query->where('slug', 'psychometrician');
        })->get();
        Notification::send($psychometricians, new SystemNotification(
            'New retake request from ' . Auth::user()->name,
            route('results.retakes.index'),
            'info'
        ));

        return back()->with('success', 'Retake request submitted to the Psychometrician.');
    }
}
