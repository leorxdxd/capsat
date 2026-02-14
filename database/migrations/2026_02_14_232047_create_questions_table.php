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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('multiple_choice'); // multiple_choice, true_false, essay
            $table->text('content');
            $table->integer('points')->default(1);
            $table->json('options')->nullable(); // For MCQ/TF choices
            $table->text('correct_answer')->nullable(); // Simple string storage for key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
