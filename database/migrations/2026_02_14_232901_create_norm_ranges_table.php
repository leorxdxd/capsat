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
        Schema::create('norm_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('norm_table_id')->constrained()->cascadeOnDelete();
            
            // Age range in years (can be decimal for months precision)
            $table->decimal('min_age', 5, 2); // E.g., 14.00 years
            $table->decimal('max_age', 5, 2); // E.g., 14.99 years
            
            // Score range
            $table->integer('min_score'); // E.g., 10
            $table->integer('max_score'); // E.g., 20
            
            // Interpretation
            $table->integer('percentile')->nullable(); // E.g., 25
            $table->string('description'); // E.g., "Low", "Average", "Above Average"
            
            $table->timestamps();
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
