<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'student_id',
        'exam_id',
        'raw_score',
        'total_score',
        'sai',
        'stanine',
        'age_at_exam',
        'grade_level_at_exam',
        'performance_description',
        'percentile',
        'psychometrician_notes',
        'counselor_notes',
        'recommendation',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'age_at_exam' => 'decimal:2',
    ];

    // Relationships
    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function signatures()
    {
        return $this->hasMany(ResultSignature::class);
    }

    public function getPerformanceDescriptionAttribute()
    {
        if (!$this->sai || $this->sai == '-') return '-';
        $val = (int)$this->sai;
        if ($val >= 128) return 'Very Superior';
        if ($val >= 120) return 'Superior';
        if ($val >= 111) return 'Above Average';
        if ($val >= 90)  return 'Average';
        if ($val >= 80)  return 'Below Average';
        if ($val >= 70)  return 'Well Below Average';
        return 'Low';
    }

    public function getAgeYearsAttribute()
    {
        return (int)floor($this->age_at_exam);
    }

    public function getAgeMonthsAttribute()
    {
        // Convert decimal part back to months (0.0833... = 1 month)
        $decimal = $this->age_at_exam - floor($this->age_at_exam);
        return (int)round($decimal * 12);
    }

    // Workflow helpers
    public function sendToCounselor()
    {
        $this->status = 'for_counselor';
        $this->save();
    }

    public function returnToPsychometrician($reason)
    {
        $this->status = 'returned';
        $this->rejection_reason = $reason;
        $this->save();
    }

    public function markAsOfficial()
    {
        $this->status = 'official';
        $this->save();
    }

    public function hasPsychometricianSignature()
    {
        return $this->signatures()->where('role', 'psychometrician')->exists();
    }

    public function hasCounselorSignature()
    {
        return $this->signatures()->where('role', 'counselor')->exists();
    }

    public function canBePrinted()
    {
        return $this->status === 'official' && 
               $this->hasPsychometricianSignature() && 
               $this->hasCounselorSignature();
    }

    /**
     * Get scores broken down by section
     */
    public function getSectionScores()
    {
        // Get the student ID associated with this result
        $studentId = $this->student_id;
        
        if (!$studentId) {
             // Fallback for edge cases (though student_id should exist)
             $attempt = $this->examAttempt;
             if (!$attempt) return collect();
             $studentId = \App\Models\Student::where('user_id', $attempt->user_id)->value('id');
        }

        // Fetch ALL attempts for this student that effectively contain answers
        // We link via the User model since attempts are tied to users
        $studentUserId = \App\Models\Student::where('id', $studentId)->value('user_id');

        if (!$studentUserId) return collect();

        // Get all attempts for this user
        $attempts = \App\Models\ExamAttempt::where('user_id', $studentUserId)
                    ->with(['answers.question.section'])
                    ->get();

        // Flatten all answers from all attempts
        $allAnswers = $attempts->pluck('answers')->flatten();

        return $allAnswers->groupBy(function ($answer) {
            return $answer->question->section->id ?? 'general';
        })->map(function ($answers) {
            $section = $answers->first()->question->section;
            return [
                'title' => $section->title ?? 'General',
                'type' => $section->section_type ?? 'intelligence',
                'raw_score' => $answers->sum('points_earned'),
                'total_items' => $answers->count(),
                'percent_score' => $answers->count() > 0 ? round(($answers->sum('points_earned') / $answers->count()) * 100) : 0,
            ];
        })->values();
    }
}
