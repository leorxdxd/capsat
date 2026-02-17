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
        Schema::table('students', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('address')->nullable()->after('current_grade_level');
            $table->string('city')->nullable()->after('address');
            $table->string('province')->nullable()->after('city');
            $table->string('contact_number')->nullable()->after('province');
            $table->string('guardian_name')->nullable()->after('contact_number');
            $table->string('guardian_contact')->nullable()->after('guardian_name');
            $table->string('guardian_relationship')->nullable()->after('guardian_contact');
            $table->string('previous_school')->nullable()->after('guardian_relationship');
            $table->string('lrn')->nullable()->after('previous_school');  // Learner Reference Number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name', 'address', 'city', 'province',
                'contact_number', 'guardian_name', 'guardian_contact',
                'guardian_relationship', 'previous_school', 'lrn',
            ]);
        });
    }
};
