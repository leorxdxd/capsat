<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'section_id',
        'type',
        'content',
        'points',
        'options',
        'correct_answer',
        'explanation',
        'media_url',
        'option_images',
    ];

    protected $casts = [
        'options' => 'array',
        'option_images' => 'array',
    ];

    /**
     * Get human-readable type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'multiple_choice' => 'Multiple Choice',
            'true_false' => 'True or False',
            'identification' => 'Identification',
            'number_series' => 'Number Series',
            'analogy' => 'Analogy',
            'sequence' => 'Sequence',
            default => ucfirst(str_replace('_', ' ', $this->type)),
        };
    }

    /**
     * Get badge CSS classes for the question type
     */
    public function getBadgeClassAttribute(): string
    {
        return match($this->type) {
            'multiple_choice' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
            'true_false' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
            'identification' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
            'number_series' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300',
            'analogy' => 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300',
            'sequence' => 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300',
            default => 'bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-300',
        };
    }

    /**
     * Get number circle CSS classes
     */
    public function getNumberClassAttribute(): string
    {
        return match($this->type) {
            'multiple_choice' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
            'true_false' => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
            'identification' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
            'number_series' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
            'analogy' => 'bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400',
            'sequence' => 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400',
            default => 'bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400',
        };
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
