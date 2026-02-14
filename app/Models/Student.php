<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'application_number',
        'current_grade_level',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Calculate age in years (with decimal precision for months)
     */
    public function getAgeInYears($asOfDate = null)
    {
        $asOfDate = $asOfDate ?? now();
        $dob = Carbon::parse($this->date_of_birth);
        
        // Calculate age in years with decimal precision
        $years = $dob->diffInYears($asOfDate);
        $months = $dob->copy()->addYears($years)->diffInMonths($asOfDate);
        
        return $years + ($months / 12);
    }
}
