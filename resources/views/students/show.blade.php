<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                    {{ $student->full_name }}
                </h2>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-semibold">Application #: {{ $student->application_number ?? 'N/A' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('students.edit', $student) }}" class="bg-sisc-gold hover:bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="hidden sm:inline">Edit Profile</span>
                </a>
                <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-sisc-purple flex items-center text-sm font-bold px-3 py-2 rounded-lg hover:bg-purple-50 transition-colors border border-transparent hover:border-purple-100">
                    <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="hidden sm:inline">All Students</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Student Profile Header -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-6 py-8">
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-inner border-2 border-white/30">
                            {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold text-white">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</h1>
                            <div class="flex flex-wrap items-center gap-3 mt-3">
                                <span class="bg-sisc-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $student->application_number ?? 'No App #' }}</span>
                                <span class="text-purple-100 font-medium">{{ $student->current_grade_level ?? 'N/A' }}</span>
                                <span class="text-purple-300">&middot;</span>
                                <span class="text-purple-100 font-medium">{{ $student->age }} years old</span>
                                <span class="text-purple-300">&middot;</span>
                                <span class="text-purple-100 font-medium">{{ $student->gender ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
                    <div class="p-6 text-center group hover:bg-gray-50 transition-colors">
                        <p class="text-3xl font-extrabold text-sisc-purple group-hover:scale-110 transition-transform">{{ $student->examAttempts->count() }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">Exam Attempts</p>
                    </div>
                    <div class="p-6 text-center group hover:bg-gray-50 transition-colors">
                        <p class="text-3xl font-extrabold text-sisc-gold group-hover:scale-110 transition-transform">{{ $student->examResults->count() }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">Results</p>
                    </div>
                    <div class="p-6 text-center group hover:bg-gray-50 transition-colors">
                        <p class="text-xl font-bold text-gray-700 mt-2">{{ $student->date_of_birth?->format('M d, Y') ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-2">Date of Birth</p>
                    </div>
                    <div class="p-6 text-center group hover:bg-gray-50 transition-colors">
                        <p class="text-xl font-bold text-gray-700 truncate px-2 mt-2">{{ $student->lrn ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-2">LRN</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-4">
                        <svg class="w-6 h-6 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Personal Details
                    </h3>
                    <dl class="space-y-4">
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->date_of_birth?->format('F d, Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">Age</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->age }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">Gender</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->gender ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">Grade Level</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->current_grade_level ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-sm font-medium text-gray-500">LRN</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $student->lrn ?? 'N/A' }}</dd>
                        </div>
                        <div class="pt-4 border-t border-gray-50 mt-4">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Previous School</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $student->previous_school ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Contact & Guardian -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                        <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-4">
                            <svg class="w-6 h-6 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Contact Information
                        </h3>
                        <dl class="space-y-4">
                            <div class="flex justify-between py-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm font-bold text-gray-900">{{ $student->user->email ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                <dd class="text-sm font-bold text-gray-900">{{ $student->contact_number ?? 'N/A' }}</dd>
                            </div>
                            <div class="pt-4 border-t border-gray-50 mt-4">
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Address</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $student->full_address ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                        <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-4">
                            <svg class="w-6 h-6 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Guardian Information
                        </h3>
                        <dl class="space-y-4">
                            <div class="flex justify-between py-1">
                                <dt class="text-sm font-medium text-gray-500">Guardian Name</dt>
                                <dd class="text-sm font-bold text-gray-900">{{ $student->guardian_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-sm font-medium text-gray-500">Relationship</dt>
                                <dd class="text-sm font-bold text-gray-900">{{ $student->guardian_relationship ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                <dd class="text-sm font-bold text-gray-900">{{ $student->guardian_contact ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Exam History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-4">
                    <svg class="w-6 h-6 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Exam History
                </h3>

                @if($student->examResults->count() > 0)
                    <div class="space-y-3">
                        @foreach($student->examResults as $result)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-purple-50 transition-colors border border-transparent hover:border-purple-100">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $result->exam->title ?? 'Unknown Exam' }}</p>
                                    <p class="text-xs text-gray-500">{{ $result->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if(isset($result->total_score))
                                        <span class="text-sm font-bold text-sisc-purple">{{ $result->total_score }} pts</span>
                                    @endif
                                    <span class="px-3 py-1 text-xs font-bold rounded-lg
                                        {{ $result->status === 'official' ? 'bg-green-100 text-green-800' : 
                                           ($result->status === 'returned' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                    </span>
                                    <a href="{{ route('results.show', $result) }}" class="text-gray-400 hover:text-sisc-purple transition-colors p-2 hover:bg-white rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="font-bold text-gray-500">No exam records yet</p>
                        <p class="text-sm mt-1 text-gray-400">This student hasn't taken any exams</p>
                    </div>
                @endif
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-lg shadow-sm p-8 border border-red-100">
                <h3 class="text-lg font-bold text-red-600 mb-2">Danger Zone</h3>
                <p class="text-sm text-gray-600 mb-6">Permanently delete this student's profile and associated user account.</p>
                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete this student? This will also delete their user account and cannot be undone.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-6 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Student Record
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

