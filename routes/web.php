<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExamController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:psychometrician'])->group(function () {
    Route::resource('exams', ExamController::class);
    
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');
    Route::post('/results/{result}/send-to-counselor', [ResultController::class, 'sendToCounselor'])->name('results.sendToCounselor');
    Route::post('/results/{result}/final-sign', [ResultController::class, 'finalSign'])->name('results.finalSign');
    Route::get('/results/{result}/pdf', [ResultController::class, 'viewPdf'])->name('results.pdf');
    Route::get('/results/{result}/pdf/download', [ResultController::class, 'downloadPdf'])->name('results.pdf.download');
    
    // Norm Table Management
    Route::resource('norms', NormTableController::class);
    Route::post('/norms/{norm}/ranges', [NormTableController::class, 'addRange'])->name('norms.addRange');
    Route::delete('/norms/{norm}/ranges/{range}', [NormTableController::class, 'deleteRange'])->name('norms.deleteRange');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore')->withTrashed();
    
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

Route::middleware(['auth', 'role:counselor'])->group(function () {
    Route::get('/counselor/reviews', [CounselorController::class, 'index'])->name('counselor.index');
    Route::get('/counselor/reviews/{result}', [CounselorController::class, 'show'])->name('counselor.show');
    Route::post('/counselor/reviews/{result}/approve', [CounselorController::class, 'approve'])->name('counselor.approve');
    Route::post('/counselor/reviews/{result}/return', [CounselorController::class, 'return'])->name('counselor.return');
});

require __DIR__.'/auth.php';
