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
        // Add extra columns to sections
        Schema::table('sections', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->text('instructions')->nullable()->after('description');
        });

        // Add extra columns to questions
        Schema::table('questions', function (Blueprint $table) {
            $table->text('explanation')->nullable()->after('correct_answer');
            $table->string('media_url')->nullable()->after('explanation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(['description', 'instructions']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['explanation', 'media_url']);
        });
    }
};
