<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'norm_table_id',
        'min_age',
        'max_age',
        'min_score',
        'max_score',
        'percentile',
        'description',
    ];

    protected $casts = [
        'min_age' => 'decimal:2',
        'max_age' => 'decimal:2',
    ];

    public function normTable()
    {
        return $this->belongsTo(NormTable::class);
    }
}
