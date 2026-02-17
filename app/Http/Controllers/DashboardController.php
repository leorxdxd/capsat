<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamResult;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard'); // Or view('dashboard.admin') if no route
        } elseif ($user->hasRole('psychometrician')) {
            $totalStudents = \App\Models\Student::count();
            $activeExams = Exam::where('active', true)->count();
            $recentResults = ExamResult::with(['student', 'exam'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('dashboard', compact('totalStudents', 'activeExams', 'recentResults'));
        } elseif ($user->hasRole('counselor')) {
            $stats = [
                'pending' => ExamResult::where('status', 'for_counselor')->count(),
                'approved' => ExamResult::where('status', 'counselor_approved')->count(),
                'total_reviewed' => \App\Models\ResultSignature::where('role', 'counselor')->where('user_id', $user->id)->count()
            ];
            
            $recentPending = ExamResult::with(['student', 'exam'])
                ->where('status', 'for_counselor')
                ->latest()
                ->take(3)
                ->get();
                
            return view('dashboard', compact('stats', 'recentPending'));
        }

        // Student dashboard logic
        $student = $user->student;
        
        if (!$student) {
            return view('dashboard', ['student' => null]);
        }

        // Available active exams
        $availableExams = Exam::where('active', true)->get();

        // Get exam attempts for the current user
        $attempts = ExamAttempt::where('user_id', $user->id)
            ->whereIn('exam_id', $availableExams->pluck('id'))
            ->get()
            ->keyBy('exam_id');

        // Filter: Show exams that are NOT completed
        $pendingExams = $availableExams->filter(function($exam) use ($attempts) {
            // Logic: Include if no attempt OR attempt is not 'completed'
            return !isset($attempts[$exam->id]) || $attempts[$exam->id]->status !== 'completed';
        });

        // Recent results
        $recentResults = ExamResult::where('student_id', $student->id)
            ->with(['exam'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('student', 'pendingExams', 'recentResults'));
    }
}
