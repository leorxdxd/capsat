<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                    {{ __('Exam Management') }}
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">Create and manage OLSAT / MAT entrance examinations</p>
            </div>
            <a href="{{ route('exams.create') }}" class="bg-gradient-to-r from-sisc-purple to-violet-800 hover:from-sisc-purple hover:to-violet-900 text-white px-5 py-2.5 rounded-lg transition-all flex items-center font-bold shadow-lg hover:shadow-xl gap-2 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="hidden sm:inline">Create New Exam</span>
                <span class="sm:hidden">New</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-lg flex items-center gap-3 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if($exams->isEmpty())
                <div class="bg-white rounded-lg shadow-lg p-12 text-center border border-gray-100">
                    <div class="w-20 h-20 mx-auto mb-6 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Exams Yet</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Get started by creating your first OLSAT or MAT entrance examination with multiple sections and question types.</p>
                    <a href="{{ route('exams.create') }}" class="inline-flex items-center bg-sisc-gold hover:bg-amber-500 text-white px-6 py-3 rounded-lg font-bold transition-all gap-2 shadow-lg hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create First Exam
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($exams as $exam)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all hover:-translate-y-1 group border border-gray-100 flex flex-col h-full">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r {{ $exam->active ? 'from-sisc-purple to-violet-800' : 'from-gray-400 to-gray-500' }} p-5 relative overflow-hidden">
                                <!-- Grid pattern -->
                                <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
                                <div class="relative flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-white truncate">{{ $exam->title }}</h3>
                                        <p class="text-white/80 text-sm mt-1 font-medium">{{ $exam->target_grade_level ?? 'All Grades' }}</p>
                                    </div>
                                    <span class="ml-2 px-2.5 py-1 text-xs font-bold rounded-full flex-shrink-0 {{ $exam->active ? 'bg-white/20 text-white backdrop-blur-sm' : 'bg-gray-300 text-gray-700' }}">
                                        {{ $exam->active ? '● Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-grow">
                                @if($exam->description)
                                    <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $exam->description }}</p>
                                @endif

                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-3 mb-6">
                                    <div class="text-center bg-purple-50 rounded-lg p-3 border border-purple-100">
                                        <p class="text-xl font-extrabold text-sisc-purple">{{ $exam->sections_count }}</p>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Sections</p>
                                    </div>
                                    <div class="text-center bg-amber-50 rounded-lg p-3 border border-amber-100">
                                        <p class="text-xl font-extrabold text-sisc-gold">{{ $exam->questions_count }}</p>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Items</p>
                                    </div>
                                    <div class="text-center bg-gray-50 rounded-lg p-3 border border-gray-100">
                                        <p class="text-xl font-extrabold text-gray-700">{{ $exam->time_limit ?? '∞' }}</p>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Mins</p>
                                    </div>
                                </div>

                                <!-- Section breakdown (mini) -->
                                @if($exam->sections_count > 0)
                                    <div class="mb-2 space-y-2">
                                        @foreach($exam->sections->take(3) as $si => $section)
                                            <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                <span class="w-2 h-2 rounded-full flex-shrink-0
                                                    @if($si % 5 === 0) bg-sisc-purple
                                                    @elseif($si % 5 === 1) bg-sisc-gold
                                                    @elseif($si % 5 === 2) bg-emerald-400
                                                    @elseif($si % 5 === 3) bg-blue-400
                                                    @else bg-rose-400
                                                    @endif"></span>
                                                <span class="truncate">{{ $section->title }}</span>
                                                <span class="ml-auto font-bold text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $section->questions->count() }}</span>
                                            </div>
                                        @endforeach
                                        @if($exam->sections_count > 3)
                                            <p class="text-xs text-sisc-purple font-semibold pl-4 pt-1">+{{ $exam->sections_count - 3 }} more sections</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="px-6 pb-6 pt-0 mt-auto">
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('exams.duplicate', $exam) }}" class="flex-shrink-0">
                                        @csrf
                                        <button type="submit" class="h-full px-3.5 rounded-lg border-2 border-gray-200 text-gray-500 hover:border-sisc-purple hover:text-sisc-purple hover:bg-purple-50 transition-all" title="Duplicate Exam" onclick="return confirm('Create a copy of this exam?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('exams.show', $exam) }}" class="flex-1 text-center bg-sisc-purple hover:bg-violet-900 text-white py-2.5 rounded-lg text-sm font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                        Manage
                                    </a>
                                    <a href="{{ route('exams.edit', $exam) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-lg text-sm font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('exams.toggleStatus', $exam) }}" class="flex-shrink-0">
                                        @csrf
                                        <button type="submit" class="h-full px-3.5 rounded-lg border-2 transition-all {{ $exam->active ? 'border-red-100 text-red-500 hover:bg-red-50 hover:border-red-300' : 'border-emerald-100 text-emerald-500 hover:bg-emerald-50 hover:border-emerald-300' }}" title="{{ $exam->active ? 'Deactivate' : 'Activate' }}">
                                            @if($exam->active)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

