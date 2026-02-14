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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_attempt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            
            // Score data
            $table->integer('raw_score');
            $table->decimal('age_at_exam', 5, 2);
            $table->string('grade_level_at_exam')->nullable();
            
            // Interpretation (from norm lookup)
            $table->string('performance_description')->nullable(); // "Low", "Average", etc.
            $table->integer('percentile')->nullable();
            
            // Recommendation (from psychometrician/counselor)
            $table->text('psychometrician_notes')->nullable();
            $table->text('counselor_notes')->nullable();
            $table->string('recommendation')->nullable(); // "Recommended", "Needs Intervention", "For Review"
            
            // Workflow status
            $table->string('status')->default('draft'); 
            // draft → for_counselor → counselor_signed → official → returned
            
            $table->text('rejection_reason')->nullable(); // If counselor returns it
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
