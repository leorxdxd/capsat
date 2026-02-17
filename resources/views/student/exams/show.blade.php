<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sisc-purple leading-tight">
            {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100">

                <!-- Hero Banner -->
                <div class="relative h-40 sm:h-48 bg-gradient-to-r from-sisc-purple to-violet-800 overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    <div class="absolute -right-10 -top-10 text-white/5 opacity-50 transform rotate-12">
                         <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                    </div>

                    <div class="absolute -bottom-10 left-8">
                        <div class="bg-white p-2 rounded-lg shadow-lg">
                            <div class="bg-purple-50 w-20 h-20 rounded-lg flex items-center justify-center border border-purple-100">
                                <svg class="w-10 h-10 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Exam type badge -->
                    <div class="absolute top-6 right-6">
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full uppercase tracking-wide border border-white/20 shadow-sm">
                            {{ $exam->target_grade_level ?? 'Entrance Exam' }}
                        </span>
                    </div>
                </div>

                <div class="pt-16 pb-8 px-8">
                    <!-- Title -->
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-3">{{ $exam->title }}</h1>
                    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 font-medium">
                        <span class="flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg">
                            <svg class="w-4 h-4 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $exam->time_limit }} minutes
                        </span>
                        <span class="flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg">
                            <svg class="w-4 h-4 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            {{ $exam->sections()->count() }} sections
                        </span>
                        <span class="flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $exam->questions()->count() }} questions
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">About This Exam</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $exam->description ?? 'This examination is designed to assess your school ability across various cognitive areas. The results help the school understand your academic strengths and guide appropriate academic placement.' }}</p>
                    </div>

                    <!-- Section Breakdown -->
                    @if($exam->sections->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Sections</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($exam->sections as $si => $section)
                                    <div class="flex items-center justify-between px-4 py-3 rounded-lg bg-gray-50 border border-gray-100 hover:border-purple-100 hover:bg-purple-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold bg-white shadow-sm text-sisc-purple border border-purple-100 h-8 w-8 min-w-[2rem]">
                                                {{ $si + 1 }}
                                            </span>
                                            <span class="text-sm font-semibold text-gray-800">{{ $section->title }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border border-gray-200">
                                            {{ $section->questions->count() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Important reminders -->
                    <div class="mt-8 p-6 bg-amber-50 rounded-lg border border-amber-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-32 h-32 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        </div>
                        <div class="relative z-10">
                             <div class="flex items-center gap-2 mb-3">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <h3 class="text-lg font-bold text-amber-800">Before You Begin</h3>
                             </div>
                             <ul class="text-sm text-amber-800 space-y-2 ml-1">
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 font-bold mt-0.5">✓</span>
                                    Ensure you have a <strong>stable internet connection</strong>.
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 font-bold mt-0.5">✓</span>
                                    You have <strong>{{ $exam->time_limit }} minutes</strong> to complete all sections.
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 font-bold mt-0.5">✓</span>
                                    The timer <strong>cannot be paused</strong> once started.
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 font-bold mt-0.5">✓</span>
                                    <strong>Do not refresh</strong> the page or press the back button.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('student.exams.index') }}" class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">
                            ← Cancel and Go Back
                        </a>

                        @if(isset($existingAttempt) && $existingAttempt->status === 'completed')
                            <button disabled class="w-full sm:w-auto bg-gray-100 text-gray-400 px-8 py-3.5 rounded-lg font-bold cursor-not-allowed border border-gray-200">
                                Exam Already Completed
                            </button>
                        @elseif(isset($existingAttempt) && $existingAttempt->status === 'in_progress')
                            <a href="{{ route('student.exams.take', $existingAttempt) }}" class="w-full sm:w-auto bg-sisc-gold hover:bg-amber-500 text-white px-10 py-3.5 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-center flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Resume Exam
                            </a>
                        @else
                            <form method="POST" action="{{ route('student.exams.start', $exam) }}" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto bg-sisc-purple hover:bg-violet-900 text-white px-12 py-3.5 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                    Start Exam Now
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

