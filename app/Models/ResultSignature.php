<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_result_id',
        'user_id',
        'role',
        'signed_at',
        'comments',
        'ip_address',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
