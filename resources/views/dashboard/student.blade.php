@php
    // Use passed $student or fallback to Auth user's student record
    $student = $student ?? Auth::user()->student;
    
    if (!isset($pendingExams)) {
        $availableExams = \App\Models\Exam::where('active', true)->get();
        // Fallback simple filter (user hasn't taken it or not completed)
        // Note: Full logic is in Controller, this is a "good enough" fallback
        $user = Auth::user();
        $attempts = \App\Models\ExamAttempt::where('user_id', $user->id)->get()->keyBy('exam_id');
        $pendingExams = $availableExams->filter(function($exam) use ($attempts) {
            return !isset($attempts[$exam->id]) || $attempts[$exam->id]->status !== 'completed';
        });
    }

    if (!isset($recentResults)) {
        $recentResults = $student 
            ? \App\Models\ExamResult::where('student_id', $student->id)->with('exam')->latest()->take(5)->get()
            : collect();
    }
@endphp

<div class="space-y-8 animate-fade-in-up">
    <!-- Welcome Header -->
    <div class="relative bg-gradient-to-r from-sisc-purple to-violet-800 rounded-lg shadow-2xl p-8 overflow-hidden">
            <!-- Decorative Background Circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-sisc-gold opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-purple-500 opacity-20 blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-purple-200 text-sm font-medium tracking-wider uppercase mb-1">{{ now()->format('l, F j, Y') }}</p>
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-purple-100 max-w-xl">Ready to take the next step in your academic journey? Your entrance exams are waiting.</p>
                </div>
                
                @if($pendingExams->count() > 0)
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-lg p-4 flex items-center gap-4 shadow-inner max-w-sm">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <svg class="w-8 h-8 text-sisc-purple" style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Exams Available</p>
                            <p class="text-purple-200 text-xs">You have {{ $pendingExams->count() }} pending exam(s).</p>
                        </div>
                        <a href="{{ route('student.exams.index') }}" class="ml-auto bg-sisc-gold text-purple-900 hover:bg-amber-400 px-4 py-2 rounded-lg text-sm font-bold transition-all hover:shadow-md">
                            View
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if($student)
            <!-- Profile Incomplete Alert -->
            @php
                $isIncomplete = !$student->date_of_birth || !$student->gender || !$student->address || !$student->guardian_name;
            @endphp
            @if($isIncomplete)
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400 opacity-10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-amber-100 p-3 rounded-lg flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-amber-900 font-bold text-lg">Complete Your Profile</h3>
                                <p class="text-amber-700 text-sm">Action required: Please update your personal information to ensure accurate exam results processing.</p>
                            </div>
                        </div>
                        <a href="{{ route('my-profile.edit') }}" class="whitespace-nowrap bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Update Now &rarr;
                        </a>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Actions (2/3) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Action Center / Exam Cards -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-purple-100 p-1.5 rounded-lg text-sisc-purple">
                                    <svg class="w-5 h-5" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </span>
                                Available Exams
                            </h2>
                            @if($pendingExams->count() > 0)
                                <a href="{{ route('student.exams.index') }}" class="text-sm font-medium text-sisc-purple hover:text-purple-800 transition-colors">See all</a>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @forelse($pendingExams->take(3) as $exam)
                                <div class="group bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:border-purple-500/30 transition-all hover:-translate-y-1 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-transparent rounded-bl-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-3 py-1 bg-purple-50 text-sisc-purple text-xs font-bold uppercase tracking-wide rounded-full">Entrance Exam</span>
                                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                                    <svg class="w-4 h-4" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ $exam->duration_minutes }} mins
                                                </span>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sisc-purple transition-colors">{{ $exam->title }}</h3>
                                            <p class="text-gray-500 text-sm line-clamp-2">{{ $exam->description ?? 'Prepare for your academic future with this assessment.' }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('student.exams.show', $exam) }}" class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-sisc-purple hover:bg-violet-900 text-white font-semibold rounded-lg shadow-md shadow-purple-200 transition-all hover:shadow-lg focus:ring-4 focus:ring-purple-500/20">
                                                Start Exam
                                                <svg class="w-5 h-5 ml-2" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-50 rounded-lg p-10 text-center border-2 border-dashed border-gray-200">
                                    <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-sm">
                                        <svg class="w-8 h-8 text-gray-400" style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">All Caught Up!</h3>
                                    <p class="text-gray-500 mt-2">You have verified all completed exams or there are no new exams available at this time.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Results -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="bg-green-100 p-1.5 rounded-lg text-green-600">
                                <svg class="w-5 h-5" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </span>
                            Recent Results
                        </h2>
                        <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                            <div class="divide-y divide-gray-100">
                                @forelse($recentResults as $result)
                                    <div class="p-5 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                @if($result->status === 'official')
                                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600 shadow-sm">
                                                        <span class="font-bold text-lg">{{ $result->stanine ?? 'A' }}</span>
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600 shadow-sm">
                                                        <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-bold text-gray-900">{{ $result->exam->title }}</h4>
                                                    <p class="text-xs text-gray-500 mt-1">Completed {{ $result->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                @if($result->status === 'official')
                                                    <div class="flex flex-col items-end">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-2">Available</span>
                                                        <a href="{{ route('student.exams.result', $result->exam_attempt_id) }}" class="text-sisc-purple hover:text-purple-700 text-sm font-semibold flex items-center">
                                                            View Result <svg class="w-4 h-4 ml-1" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Processing</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <p class="text-gray-500">No exam results to display yet.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($recentResults->count() > 0)
                                <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                                    <a href="{{ route('student.exams.index') }}" class="text-sm font-medium text-sisc-purple hover:text-purple-800">View All History</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Stats & Profile (1/3) -->
                <div class="space-y-8">
                    <!-- Profile Summary -->
                    <div class="bg-white rounded-lg shadow-xl p-8 border border-gray-100 text-center relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-b from-purple-50 to-transparent"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-sisc-purple to-violet-600 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg mb-4 ring-4 ring-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                            <p class="text-gray-500 text-sm mb-6">{{ Auth::user()->email }}</p>
                            
                            <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-6">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Grade</p>
                                    <p class="font-bold text-gray-800 text-lg">{{ $student->current_grade_level ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">App ID</p>
                                    <p class="font-bold text-gray-800 text-lg">{{ $student->application_number ?? '-' }}</p>
                                </div>
                            </div>

                            <a href="{{ route('my-profile.edit') }}" class="mt-8 block w-full py-3 bg-white border border-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Progress Stats -->
                    <div class="bg-white rounded-lg shadow-xl p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-6">Your Progress</h3>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Exams Taken</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $student->examAttempts()->count() }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(100, $student->examAttempts()->count() * 10) }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Completed</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $recentResults->where('status', 'official')->count() }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ min(100, $recentResults->where('status', 'official')->count() * 20) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20 bg-white rounded-lg shadow-xl border border-gray-100 max-w-2xl mx-auto mt-10">
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-yellow-600" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Student Profile Not Found</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">We couldn't retrieve your student information. Please reach out to support for assistance.</p>
            </div>
        @endif
</div>

