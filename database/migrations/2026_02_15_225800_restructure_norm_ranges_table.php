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
        Schema::dropIfExists('norm_ranges');

        Schema::create('norm_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('norm_table_id')->constrained()->cascadeOnDelete();

            // Age bracket (e.g., AGE 14 0-2 means age 14, months 0 to 2)
            $table->integer('age_years');         // e.g. 14
            $table->integer('age_months_start');  // e.g. 0
            $table->integer('age_months_end');    // e.g. 2

            // Score data per row
            $table->integer('raw_score');          // RS (e.g. 21)
            $table->integer('sai');                // School Ability Index (e.g. 53)
            $table->integer('percentile');         // %TILE (e.g. 1)
            $table->integer('stanine');            // STA (1-9, e.g. 1)
            $table->string('description');         // DES (e.g. "L - Low")

            $table->timestamps();

            // Index for fast lookups
            $table->index(['norm_table_id', 'age_years', 'age_months_start', 'age_months_end', 'raw_score'], 'norm_lookup_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('norm_ranges');
    }
};
