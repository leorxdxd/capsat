<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $achievementKeywords = [
            'Math',
            'Reading',
            'Science',
            'Language',
            'Achievement'
        ];

        foreach ($achievementKeywords as $keyword) {
            \Illuminate\Support\Facades\DB::table('sections')
                ->where('title', 'LIKE', '%' . $keyword . '%')
                ->update(['section_type' => 'achievement']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert all to intelligence (default)
        \Illuminate\Support\Facades\DB::table('sections')
            ->where('section_type', 'achievement')
            ->update(['section_type' => 'intelligence']);
    }
};
