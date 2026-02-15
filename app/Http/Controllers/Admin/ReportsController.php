<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamAttempt;
use App\Models\Student;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display the reports & analytics dashboard
     */
    public function index()
    {
        // User Statistics
        $userStats = [
            'total' => User::count(),
            'active' => User::whereNull('deleted_at')->count(),
            'inactive' => User::onlyTrashed()->count(),
            'by_role' => DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('roles.name as role', DB::raw('count(*) as count'))
                ->whereNull('users.deleted_at')
                ->groupBy('roles.name')
                ->get(),
        ];

        // Exam Statistics
        $examStats = [
            'total' => Exam::count(),
            'active' => Exam::where('active', true)->count(),
            'inactive' => Exam::where('active', false)->count(),
            'total_questions' => DB::table('questions')->count(),
            'total_sections' => DB::table('sections')->count(),
        ];

        // Result Statistics
        $resultStats = [
            'total' => ExamResult::count(),
            'pending' => ExamResult::where('status', 'pending_counselor')->count(),
            'reviewed' => ExamResult::where('status', 'counselor_reviewed')->count(),
            'completed' => ExamResult::where('status', 'completed')->count(),
        ];

        // Student Statistics
        $studentStats = [
            'total' => Student::count(),
            'with_results' => Student::has('examAttempts')->count(),
        ];

        // Recent Activity (last 30 days)
        $recentActivity = AuditLog::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        // Monthly Registration Trend (last 6 months)
        $registrationTrend = DB::table('users')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Exam Completion by Status
        $resultsByStatus = DB::table('exam_results')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact(
            'userStats',
            'examStats',
            'resultStats',
            'studentStats',
            'recentActivity',
            'registrationTrend',
            'resultsByStatus'
        ));
    }
}
