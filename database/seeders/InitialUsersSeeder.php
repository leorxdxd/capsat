<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;

class InitialUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $psychRole = Role::where('slug', 'psychometrician')->first();
        $counselorRole = Role::where('slug', 'counselor')->first();
        $studentRole = Role::where('slug', 'student')->first();

        // Create System Administrator
        $admin = User::create([
            'name' => 'Roel Delos Reyes',
            'email' => 'roeldelosreyes0105@gmail.com',
            'password' => Hash::make('Admin@2026'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        // Create Psychometrician
        $psych = User::create([
            'name' => 'Roel D. Reyes',
            'email' => 'roeldlreyes@gmail.com',
            'password' => Hash::make('Psych@2026'),
            'role_id' => $psychRole->id,
            'email_verified_at' => now(),
        ]);

        // Create Counselor
        $counselor = User::create([
            'name' => 'IT Support',
            'email' => 'itsupport@southville.edu.ph',
            'password' => Hash::make('Counselor@2026'),
            'role_id' => $counselorRole->id,
            'email_verified_at' => now(),
        ]);

        // Create Student
        $studentUser = User::create([
            'name' => 'Student Demo',
            'email' => '24-0209c@sgen.edu.ph',
            'password' => Hash::make('Student@2026'),
            'role_id' => $studentRole->id,
            'email_verified_at' => now(),
        ]);

        // Create student profile
        Student::create([
            'user_id' => $studentUser->id,
            'first_name' => 'Student',
            'last_name' => 'Demo',
            'date_of_birth' => '2010-01-15', // 14 years old
            'gender' => 'Male',
            'application_number' => '24-0209C',
            'current_grade_level' => 'Grade 9',
        ]);

        $this->command->info('✅ Initial users created successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('');
        $this->command->info('System Administrator:');
        $this->command->info('  Email: roeldelosreyes0105@gmail.com');
        $this->command->info('  Password: Admin@2026');
        $this->command->info('');
        $this->command->info('Psychometrician:');
        $this->command->info('  Email: roeldlreyes@gmail.com');
        $this->command->info('  Password: Psych@2026');
        $this->command->info('');
        $this->command->info('Counselor:');
        $this->command->info('  Email: itsupport@southville.edu.ph');
        $this->command->info('  Password: Counselor@2026');
        $this->command->info('');
        $this->command->info('Student:');
        $this->command->info('  Email: 24-0209c@sgen.edu.ph');
        $this->command->info('  Password: Student@2026');
    }
}
