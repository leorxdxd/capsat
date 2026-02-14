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
}
