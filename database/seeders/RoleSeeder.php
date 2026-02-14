<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'System Administrator',
                'slug' => 'admin',
                'description' => 'Full access to system settings and user management.',
            ],
            [
                'name' => 'Psychometrician',
                'slug' => 'psychometrician',
                'description' => 'Manage assessments, scoring, and results.',
            ],
            [
                'name' => 'Guidance Counselor',
                'slug' => 'counselor',
                'description' => 'Review results and provide recommendations.',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Take exams and view personal results.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
