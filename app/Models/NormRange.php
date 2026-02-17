<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'norm_table_id',
        'age_years',
        'age_months_start',
        'age_months_end',
        'raw_score',
        'sai',
        'percentile',
        'stanine',
        'description',
    ];

    public function normTable()
    {
        return $this->belongsTo(NormTable::class);
    }

    /**
     * Get the RSCODE (age + raw_score code)
     */
    public function getRscodeAttribute(): string
    {
        return $this->age_years . '+' . $this->raw_score;
    }

    /**
     * Get the age bracket label
     */
    public function getAgeBracketLabelAttribute(): string
    {
        return "AGE {$this->age_years} {$this->age_months_start}-{$this->age_months_end}";
    }
}
