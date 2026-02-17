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
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'application_number',
        'current_grade_level',
        'address',
        'city',
        'province',
        'contact_number',
        'guardian_name',
        'guardian_contact',
        'guardian_relationship',
        'previous_school',
        'lrn',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        $parts = [$this->first_name];
        if ($this->middle_name) {
            $parts[] = $this->middle_name;
        }
        $parts[] = $this->last_name;
        return implode(' ', $parts);
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([$this->address, $this->city, $this->province]);
        return count($parts) > 0 ? implode(', ', $parts) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Exam attempts are linked via user_id (not student_id)
     */
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class, 'user_id', 'user_id');
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Calculate age in years (with decimal precision for months)
     */
    public function getAgeInYears($asOfDate = null)
    {
        $asOfDate = $asOfDate ?? now();
        $dob = Carbon::parse($this->date_of_birth);
        
        $years = $dob->diffInYears($asOfDate);
        $months = $dob->copy()->addYears($years)->diffInMonths($asOfDate);
        
        return $years + ($months / 12);
    }

    /**
     * Decompose age into years and months
     */
    public function getAgeDecomposed($asOfDate = null): array
    {
        $asOfDate = $asOfDate ?? now();
        $dob = Carbon::parse($this->date_of_birth);
        
        $years = $dob->diffInYears($asOfDate);
        $months = $dob->copy()->addYears($years)->diffInMonths($asOfDate);
        
        return [
            'years' => (int)$years,
            'months' => (int)$months,
        ];
    }

    /**
     * Get age as a readable string
     */
    public function getAgeAttribute(): string
    {
        if (!$this->date_of_birth) return 'N/A';
        $dob = Carbon::parse($this->date_of_birth);
        $years = $dob->diffInYears(now());
        return $years . ' years old';
    }
}
