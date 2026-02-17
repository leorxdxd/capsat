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
        Schema::table('exam_results', function (Blueprint $table) {
            $table->integer('sai')->nullable()->after('raw_score');
            $table->integer('stanine')->nullable()->after('percentile');
            $table->integer('total_score')->nullable()->after('exam_id'); // Re-adding if needed for consistency
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropColumn(['sai', 'stanine', 'total_score']);
        });
    }
};
