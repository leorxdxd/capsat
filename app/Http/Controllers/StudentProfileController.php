<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentProfileController extends Controller
{
    /**
     * Show the student's profile completion / edit form
     */
    public function edit()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            // Auto-initialize student record if missing for a student user
            $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'application_number' => 'APP-' . strtoupper(substr(uniqid(), 0, 8)),
                'current_grade_level' => 'Pending',
                'first_name' => explode(' ', $user->name)[0] ?? 'Student',
                'last_name' => count(explode(' ', $user->name)) > 1 ? end(explode(' ', $user->name)) : '',
            ]);
        }

        return view('students.my-profile', compact('student'));
    }

    /**
     * Update the student's own profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'application_number' => 'APP-' . strtoupper(substr(uniqid(), 0, 8)),
                'current_grade_level' => 'Pending',
            ]);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|string|in:Male,Female',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:200',
            'guardian_contact' => 'nullable|string|max:20',
            'guardian_relationship' => 'nullable|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'lrn' => 'nullable|string|max:20',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        // Update student profile
        $studentData = collect($validated)->except(['email'])->toArray();
        $student->update($studentData);

        // Update user name and email
        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('my-profile.edit')->with('success', 'Your profile has been updated successfully.');
    }
}
