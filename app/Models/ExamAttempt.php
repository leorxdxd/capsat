<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAttempt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_id',
        'started_at',
        'submitted_at',
        'status',
        'raw_score',
        'age_at_attempt',
        'grade_level_at_attempt',
        'retake_requested_at',
        'retake_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'retake_requested_at' => 'datetime',
        'age_at_attempt' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function examResult()
    {
        return $this->hasOne(ExamResult::class);
    }

    /**
     * Calculate raw score from answers
     */
    public function calculateRawScore()
    {
        return $this->answers()->sum('points_earned');
    }
}
