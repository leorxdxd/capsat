<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\NormTableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notifications
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});

Route::middleware(['auth', 'role:psychometrician'])->group(function () {
    // Student Management
    Route::resource('students', StudentController::class);
    Route::get('students-bulk', [StudentController::class, 'bulkCreate'])->name('students.bulk.create');
    Route::post('students-bulk', [StudentController::class, 'bulkStore'])->name('students.bulk.store');

    // Exam CRUD
    Route::resource('exams', ExamController::class);
    Route::post('exams/{exam}/toggle-status', [ExamController::class, 'toggleStatus'])->name('exams.toggleStatus');
    Route::post('exams/{exam}/duplicate', [ExamController::class, 'duplicate'])->name('exams.duplicate');
    Route::get('exams/{exam}/preview', [ExamController::class, 'preview'])->name('exams.preview');
    
    // Section Management
    Route::post('exams/{exam}/sections', [ExamController::class, 'storeSection'])->name('exams.sections.store');
    Route::put('exams/{exam}/sections/{section}', [ExamController::class, 'updateSection'])->name('exams.sections.update');
    Route::delete('exams/{exam}/sections/{section}', [ExamController::class, 'destroySection'])->name('exams.sections.destroy');
    
    // Question Management
    Route::post('exams/{exam}/sections/{section}/questions', [ExamController::class, 'storeQuestion'])->name('exams.questions.store');
    Route::put('exams/{exam}/sections/{section}/questions/{question}', [ExamController::class, 'updateQuestion'])->name('exams.questions.update');
    Route::delete('exams/{exam}/sections/{section}/questions/{question}', [ExamController::class, 'destroyQuestion'])->name('exams.questions.destroy');
    
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');
    Route::post('/results/{result}/send-to-counselor', [ResultController::class, 'sendToCounselor'])->name('results.sendToCounselor');
    Route::post('/results/{result}/final-sign', [ResultController::class, 'finalSign'])->name('results.finalSign');
    Route::get('/results/{result}/pdf', [ResultController::class, 'viewPdf'])->name('results.pdf');
    Route::get('/results/{result}/pdf/download', [ResultController::class, 'downloadPdf'])->name('results.pdf.download');
    
    // Norm Table Management
    Route::resource('norms', NormTableController::class);
    Route::get('/norms/{norm}/import', [NormTableController::class, 'import'])->name('norms.import');
    Route::post('/norms/{norm}/import', [NormTableController::class, 'processImport'])->name('norms.processImport');
    Route::post('/norms/{norm}/check', [NormTableController::class, 'check'])->name('norms.check');
    Route::post('/norms/{norm}/ranges', [NormTableController::class, 'addRange'])->name('norms.addRange');
    Route::post('/norms/{norm}/bulk', [NormTableController::class, 'addBulk'])->name('norms.addBulk');
    Route::delete('/norms/{norm}/ranges/{range}', [NormTableController::class, 'deleteRange'])->name('norms.deleteRange');
    Route::delete('/norms/{norm}/bracket', [NormTableController::class, 'deleteBracket'])->name('norms.deleteBracket');
    
    // Retake Management
    Route::get('/exam-retakes', [ResultController::class, 'indexRetakeRequests'])->name('results.retakes.index');
    Route::post('/exam-retakes/{attempt}/approve', [ResultController::class, 'approveRetake'])->name('results.retakes.approve');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $activities = \App\Models\AuditLog::with('user')
            ->latest('created_at')
            ->take(5)
            ->get();
            
        // Stats for Super Admin Oversight
        $totalStudents = \App\Models\Student::count();
        $activeExams = \App\Models\Exam::where('active', true)->count();
        $recentResults = \App\Models\ExamResult::with(['student', 'exam'])
            ->latest()
            ->take(5)
            ->get();
            
        return view('dashboard', compact('activities', 'totalStudents', 'activeExams', 'recentResults'));
    })->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore')->withTrashed();
    Route::post('users/{user}/impersonate', [UserController::class, 'impersonate'])
        ->name('users.impersonate')
        ->middleware('password.confirm');
    
    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Audit Logs
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('audit-logs/export', [AuditLogController::class, 'export'])->name('audit.export');
    
    // Database Backup
    Route::get('backups', [BackupController::class, 'index'])->name('backup.index');
    Route::post('backups', [BackupController::class, 'create'])->name('backup.create');
    Route::get('backups/{filename}', [BackupController::class, 'download'])->name('backup.download');
    Route::delete('backups/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy');
    
    // Reports & Analytics
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/impersonate/leave', [UserController::class, 'stopImpersonating'])->name('impersonate.leave');
});

Route::middleware(['auth', 'role:counselor'])->group(function () {
    Route::get('/counselor/reviews', [CounselorController::class, 'index'])->name('counselor.index');
    Route::get('/counselor/history', [CounselorController::class, 'history'])->name('counselor.history');
    Route::get('/counselor/reviews/{result}', [CounselorController::class, 'show'])->name('counselor.show');
    Route::post('/counselor/reviews/{result}/approve', [CounselorController::class, 'approve'])->name('counselor.approve');
    Route::post('/counselor/reviews/{result}/return', [CounselorController::class, 'return'])->name('counselor.return');
    // PDF Routes for Counselors
    Route::get('/counselor/reviews/{result}/pdf', [ResultController::class, 'viewPdf'])->name('counselor.pdf');
    Route::get('/counselor/reviews/{result}/pdf/download', [ResultController::class, 'downloadPdf'])->name('counselor.pdf.download');
});
// Student Self-Profile Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/my-profile', [StudentProfileController::class, 'edit'])->name('my-profile.edit');
    Route::put('/my-profile', [StudentProfileController::class, 'update'])->name('my-profile.update');
    
    // Exam Taking Routes
    Route::get('/my-exams', [App\Http\Controllers\StudentExamController::class, 'index'])->name('student.exams.index');
    Route::get('/my-exams/{exam}', [App\Http\Controllers\StudentExamController::class, 'show'])->name('student.exams.show');
    Route::post('/my-exams/{exam}/start', [App\Http\Controllers\StudentExamController::class, 'start'])->name('student.exams.start');
    Route::get('/exam-attempt/{attempt}', [App\Http\Controllers\StudentExamController::class, 'take'])->name('student.exams.take');
    Route::post('/exam-attempt/{attempt}/submit', [App\Http\Controllers\StudentExamController::class, 'submit'])->name('student.exams.submit');
    Route::get('/exam-attempt/{attempt}/result', [App\Http\Controllers\StudentExamController::class, 'showResult'])->name('student.exams.result');
    Route::post('/exam-attempt/{attempt}/retake', [App\Http\Controllers\StudentExamController::class, 'requestRetake'])->name('student.exams.retake');
});

require __DIR__.'/auth.php';
