<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {
        $query = Student::with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('application_number', 'like', "%{$search}%")
                  ->orWhere('lrn', 'like', "%{$search}%");
            });
        }

        // Filter by grade level
        if ($request->filled('grade_level')) {
            $query->where('current_grade_level', $request->grade_level);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|string|in:Male,Female',
            'current_grade_level' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:200',
            'guardian_contact' => 'nullable|string|max:20',
            'guardian_relationship' => 'nullable|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'lrn' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            // Create user account
            $studentRole = Role::where('slug', 'student')->first();
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'), // Default password
                'role_id' => $studentRole->id,
            ]);

            // Generate application number
            $year = date('Y');
            $count = Student::whereYear('created_at', $year)->count() + 1;
            $appNumber = 'SISC-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            // Create student profile
            $studentData = collect($validated)->except(['email'])->toArray();
            $studentData['user_id'] = $user->id;
            $studentData['application_number'] = $appNumber;

            Student::create($studentData);

            AuditLog::log('student.created', 'Registered student: ' . $validated['first_name'] . ' ' . $validated['last_name']);
        });

        return redirect()->route('students.index')->with('success', 'Student registered successfully. Default password is "password".');
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        $student->load(['user', 'examAttempts.exam', 'examResults.exam']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|string|in:Male,Female',
            'current_grade_level' => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:200',
            'guardian_contact' => 'nullable|string|max:20',
            'guardian_relationship' => 'nullable|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'lrn' => 'nullable|string|max:20',
        ]);

        $student->update($validated);

        // Update user name too
        $student->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
        ]);

        AuditLog::log('student.updated', 'Updated student: ' . $student->full_name, $student);

        return redirect()->route('students.show', $student)->with('success', 'Student profile updated successfully.');
    }

    /**
     * Remove the specified student
     */
    public function destroy(Student $student)
    {
        $name = $student->full_name;
        
        // Delete user account too
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();

        AuditLog::log('student.deleted', 'Deleted student: ' . $name);

        return redirect()->route('students.index')->with('success', 'Student record deleted successfully.');
    }

    /**
     * Show bulk registration form
     */
    public function bulkCreate()
    {
        return view('students.bulk-create');
    }

    /**
     * Process bulk student registration
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:1',
            'students.*.first_name' => 'required|string|max:100',
            'students.*.last_name' => 'required|string|max:100',
            'students.*.email' => 'required|email|distinct',
            'students.*.current_grade_level' => 'required|string|max:50',
        ]);

        // Check for duplicate emails against existing users
        $emails = collect($request->students)->pluck('email');
        $existingEmails = User::whereIn('email', $emails)->pluck('email');
        if ($existingEmails->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'duplicate_emails' => 'These emails already exist: ' . $existingEmails->join(', ')
            ]);
        }

        $count = 0;
        $credentials = [];

        DB::transaction(function () use ($request, &$count, &$credentials) {
            $studentRole = Role::where('slug', 'student')->first();
            $year = date('Y');
            $baseCount = Student::whereYear('created_at', $year)->count();

            foreach ($request->students as $data) {
                $baseCount++;
                $appNumber = 'SISC-' . $year . '-' . str_pad($baseCount, 4, '0', STR_PAD_LEFT);
                $password = \Illuminate\Support\Str::random(8);

                $user = User::create([
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                    'role_id' => $studentRole->id,
                    'email_verified_at' => now(),
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'first_name' => $data['first_name'],
                    'middle_name' => $data['middle_name'] ?? null,
                    'last_name' => $data['last_name'],
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'current_grade_level' => $data['current_grade_level'],
                    'application_number' => $appNumber,
                ]);

                $credentials[] = [
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                    'password' => $password,
                    'app_number' => $appNumber,
                    'grade' => $data['current_grade_level']
                ];

                $count++;
            }

            AuditLog::log('student.bulk_created', "Bulk registered {$count} students");
        });

        return view('students.credentials', compact('credentials', 'count'));
    }
}
