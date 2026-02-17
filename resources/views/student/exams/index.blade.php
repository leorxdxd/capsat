<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-sisc-purple leading-tight">
            {{ __('My Exams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($exams as $exam)
                    @php
                        $attempt = $attempts[$exam->id] ?? null;
                        $status = $attempt ? $attempt->status : 'not_started';
                    @endphp
                    
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-sisc-purple border border-purple-100 uppercase tracking-wide">
                                    {{ $exam->target_grade_level ?? 'All Levels' }}
                                </span>
                                @if($status === 'completed')
                                    <span class="flex items-center text-emerald-600 text-sm font-bold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Completed
                                    </span>
                                @elseif($status === 'in_progress')
                                    <span class="flex items-center text-amber-600 text-sm font-bold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        In Progress
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm font-medium">Not Started</span>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-extrabold text-gray-900 mb-2">{{ $exam->title }}</h3>
                            <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">{{ $exam->description }}</p>
                            
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-500 font-medium">
                                    <div class="w-8 flex justify-center">
                                        <svg class="w-4 h-4 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    {{ $exam->time_limit }} minutes
                                </div>
                                <div class="flex items-center text-sm text-gray-500 font-medium">
                                    <div class="w-8 flex justify-center">
                                        <svg class="w-4 h-4 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    {{ $exam->sections_count ?? 0 }} sections
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            @if($status === 'completed')
                                <a href="{{ route('student.exams.result', $attempt) }}" class="block w-full bg-white hover:bg-gray-50 text-sisc-purple border-2 border-sisc-purple px-4 py-2.5 rounded-lg font-bold text-center transition-all hover:shadow-md">
                                    View Result
                                </a>
                            @elseif($status === 'in_progress')
                                <a href="{{ route('student.exams.show', $exam) }}" class="block w-full bg-sisc-gold hover:bg-amber-500 text-white px-4 py-2.5 rounded-lg font-bold text-center transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    Resume Exam
                                </a>
                            @else
                                <a href="{{ route('student.exams.show', $exam) }}" class="block w-full bg-sisc-purple hover:bg-violet-900 text-white px-4 py-2.5 rounded-lg font-bold text-center transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    Start Exam
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow-lg p-12 text-center border border-gray-100">
                             <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             </div>
                             <h3 class="text-xl font-bold text-gray-900 mb-2">No Exams Available</h3>
                             <p class="text-gray-500">There are no exams assigned to your grade level at this time.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

