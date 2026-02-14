<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'answer_text',
        'is_correct',
        'points_earned',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Auto-check answer against question's correct answer
     */
    public function checkCorrectness()
    {
        if ($this->question->correct_answer === null) {
            return; // Manual grading required
        }

        $this->is_correct = trim(strtolower($this->answer_text)) === trim(strtolower($this->question->correct_answer));
        $this->points_earned = $this->is_correct ? $this->question->points : 0;
        $this->save();
    }
}
