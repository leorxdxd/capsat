<div class="space-y-8 animate-fade-in-up">
    <!-- Welcome Section -->
    <div class="relative bg-gradient-to-r from-sisc-purple to-violet-800 rounded-lg shadow-2xl p-8 overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-sisc-gold opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-purple-500 opacity-20 blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <p class="text-purple-100 text-sm font-medium tracking-wider uppercase mb-1">{{ now()->format('l, F j, Y') }}</p>
                    <h1 class="text-3xl font-bold text-white mb-2">Psychometrics Dashboard</h1>
                    <p class="text-purple-50 max-w-xl">Overview of student performance, active assessments, and pending tasks.</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('exams.create') }}" class="bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-white/20 px-5 py-2.5 rounded-lg text-sm font-bold transition-all hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Exam
                    </a>
                    <a href="{{ route('students.create') }}" class="bg-sisc-gold text-purple-900 hover:bg-amber-400 px-5 py-2.5 rounded-lg text-sm font-bold transition-all hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Add Student
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Students -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-default">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-sisc-purple" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Students</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</h3>
                        <a href="{{ route('students.index') }}" class="inline-flex items-center text-xs font-medium text-sisc-purple hover:text-purple-800 mt-2 hover:underline">
                            View List &rarr;
                        </a>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-sisc-purple shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Active Exams -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-default">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path></svg>
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Exams</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $activeExams }}</h3>
                        <a href="{{ route('exams.index') }}" class="inline-flex items-center text-xs font-medium text-emerald-600 hover:text-emerald-800 mt-2 hover:underline">
                            Manage Exams &rarr;
                        </a>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Recent Results -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-default">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-sisc-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Recent Results</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $recentResults->count() }}</h3>
                        <a href="{{ route('results.index') }}" class="inline-flex items-center text-xs font-medium text-sisc-gold hover:text-amber-600 mt-2 hover:underline">
                            Processing Queue &rarr;
                        </a>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center text-sisc-gold shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Recent Activity (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-sisc-purple"></span>
                            Recent Submissions
                        </h3>
                        <a href="{{ route('results.index') }}" class="text-sm font-medium text-sisc-purple hover:text-purple-800 transition-colors">See all history</a>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($recentResults as $result)
                            <div class="p-5 hover:bg-gray-50 transition-colors group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm ring-2 ring-white shadow-sm">
                                            {{ substr($result->student->first_name ?? '?', 0, 1) }}{{ substr($result->student->last_name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 group-hover:text-sisc-purple transition-colors">{{ $result->student->full_name ?? 'Unknown Student' }}</h4>
                                            <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                                <span>{{ $result->exam->title ?? 'Deleted Exam' }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span>{{ $result->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            @if($result->status === 'official')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Processed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending Review
                                                </span>
                                            @endif
                                            
                                            <span class="text-xs font-mono text-gray-500">Score: {{ $result->raw_score ?? '-' }}/{{ $result->total_items ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">All Caught Up!</h3>
                                <p class="text-gray-500 text-sm mt-1">No recent exam submissions found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Actions (1/3) -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('students.create') }}" class="group flex items-center p-3 rounded-lg hover:bg-purple-50 transition-all border border-transparent hover:border-purple-100">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-sisc-purple group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-sisc-purple transition-colors">Register Student</p>
                                <p class="text-xs text-gray-500">Add new applicant profile</p>
                            </div>
                            <svg class="w-4 h-4 ml-auto text-gray-300 group-hover:text-sisc-purple group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        <a href="{{ route('exams.create') }}" class="group flex items-center p-3 rounded-lg hover:bg-emerald-50 transition-all border border-transparent hover:border-emerald-100">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Create Exam</p>
                                <p class="text-xs text-gray-500">Build new assessment</p>
                            </div>
                            <svg class="w-4 h-4 ml-auto text-gray-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        <a href="{{ route('norms.index') }}" class="group flex items-center p-3 rounded-lg hover:bg-pink-50 transition-all border border-transparent hover:border-pink-100">
                            <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-pink-600 transition-colors">Manage Norms</p>
                                <p class="text-xs text-gray-500">Configure score tables</p>
                            </div>
                            <svg class="w-4 h-4 ml-auto text-gray-300 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        <a href="{{ route('results.index') }}" class="group flex items-center p-3 rounded-lg hover:bg-amber-50 transition-all border border-transparent hover:border-amber-100">
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-sisc-gold group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-sisc-gold transition-colors">Exam Results</p>
                                <p class="text-xs text-gray-500">Review analytics & reports</p>
                            </div>
                            <svg class="w-4 h-4 ml-auto text-gray-300 group-hover:text-sisc-gold group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Help Tip (Optional) -->
                <div class="bg-gradient-to-br from-sisc-purple to-violet-800 rounded-lg shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="font-bold text-lg mb-2">Need Help?</h4>
                        <p class="text-purple-100 text-sm mb-4">Check the user guide to learn how to manage norms and calibrate scoring.</p>
                        <a href="#" class="inline-block bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors backdrop-blur-sm">
                            View Documentation
                        </a>
                    </div>
                    <!-- Decor -->
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-sisc-gold opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute top-0 right-0 p-4 opacity-20">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
</div>

