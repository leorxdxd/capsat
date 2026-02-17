<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'name',
        'description',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function normRanges()
    {
        return $this->hasMany(NormRange::class);
    }

    /**
     * Find the norm entry for a given age (years + months) and raw score
     */
    public function findNormRange(int $ageYears, int $ageMonths, int $rawScore)
    {
        return $this->normRanges()
            ->where('age_years', $ageYears)
            ->where('age_months_start', '<=', $ageMonths)
            ->where('age_months_end', '>=', $ageMonths)
            ->where('raw_score', $rawScore)
            ->first();
    }

    /**
     * Get all entries grouped by age bracket
     */
    public function getGroupedRanges()
    {
        return $this->normRanges()
            ->orderBy('age_years')
            ->orderBy('age_months_start')
            ->orderBy('raw_score')
            ->get()
            ->groupBy(function ($range) {
                return "{$range->age_years}_{$range->age_months_start}_{$range->age_months_end}";
            });
    }
}
