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
     * Find the appropriate norm range for a given age and score
     */
    public function findNormRange($age, $score)
    {
        return $this->normRanges()
            ->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->first();
    }
}
