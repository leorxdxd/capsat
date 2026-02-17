<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('exams.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-sisc-purple transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Exams
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-bold text-sisc-purple md:ml-2 tracking-tight">Create New Exam</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-3xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Setup New Examination') }}
                </h2>
            </div>
            <a href="{{ route('exams.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:text-sisc-purple hover:border-purple-200 rounded-lg text-sm font-bold transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 max-w-[1200px] mx-auto">
            <div class="bg-white rounded-lg shadow-2xl border border-gray-100 overflow-hidden animate-fade-in-up">
                <!-- Premium Header Section -->
                <div class="relative bg-gradient-to-r from-sisc-purple to-violet-800 px-8 py-10 overflow-hidden">
                    <!-- Decorative Background Circles -->
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-sisc-gold opacity-10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-purple-500 opacity-20 blur-2xl"></div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-white flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-lg backdrop-blur-md">
                                <svg class="w-6 h-6 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            Exam Configuration
                        </h3>
                        <p class="text-purple-100 text-sm mt-3 max-w-2xl leading-relaxed">
                            Define the structural parameters of your new entrance examination. You'll be able to populate questions and sections immediately after creating this container.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('exams.store') }}" class="p-8 lg:p-10 space-y-8">
                    @csrf

                    <!-- Primary Info Group -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 text-sisc-purple mb-2">
                            <span class="w-1.5 h-6 bg-sisc-purple rounded-full"></span>
                            <h4 class="font-bold uppercase tracking-widest text-xs">General Information</h4>
                        </div>
                        
                        <div>
                            <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Exam Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="w-full border-gray-200 rounded-lg shadow-sm focus:ring-4 focus:ring-purple-500/10 focus:border-sisc-purple transition-all py-3 px-4 font-semibold text-gray-900"
                                   placeholder="e.g. Grade 7 Entrance Examination 2026">
                            @error('title') <p class="text-red-500 text-xs mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full border-gray-200 rounded-lg shadow-sm focus:ring-4 focus:ring-purple-500/10 focus:border-sisc-purple transition-all py-3 px-4 text-gray-700"
                                      placeholder="Briefly describe the scope or purpose of this assessment...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Constraints Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-gray-100">
                        <div class="space-y-6">
                            <div class="flex items-center gap-2 text-sisc-purple mb-2">
                                <span class="w-1.5 h-6 bg-sisc-purple rounded-full"></span>
                                <h4 class="font-bold uppercase tracking-widest text-xs">Academic Targeting</h4>
                            </div>
                            
                            <div>
                                <label for="target_grade_level" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Target Grade Level</label>
                                <div class="relative">
                                    <select id="target_grade_level" name="target_grade_level"
                                            class="w-full border-gray-200 rounded-lg shadow-sm focus:ring-4 focus:ring-purple-500/10 focus:border-sisc-purple transition-all py-3 pl-4 pr-10 appearance-none font-semibold text-gray-900">
                                        <option value="">All Grades (Open Assessment)</option>
                                        @foreach(['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                            <option value="{{ $grade }}" {{ old('target_grade_level') === $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 font-medium">Leave as "All Grades" if the exam is universal.</p>
                                @error('target_grade_level') <p class="text-red-500 text-xs mt-1.5 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-2 text-sisc-purple mb-2">
                                <span class="w-1.5 h-6 bg-sisc-purple rounded-full"></span>
                                <h4 class="font-bold uppercase tracking-widest text-xs">Assessment Controls</h4>
                            </div>

                            <div>
                                <label for="time_limit" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Time Limit (Minutes)</label>
                                <div class="relative">
                                    <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit') }}" min="1"
                                           class="w-full border-gray-200 rounded-lg shadow-sm focus:ring-4 focus:ring-purple-500/10 focus:border-sisc-purple transition-all py-3 pl-11 pr-4 font-semibold text-gray-900"
                                           placeholder="No limit">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 font-medium">Students will see a countdown timer during the attempt.</p>
                                @error('time_limit') <p class="text-red-500 text-xs mt-1.5 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50">
                        <a href="{{ route('exams.index') }}" class="px-6 py-3 text-gray-500 hover:text-gray-700 font-bold text-sm rounded-lg hover:bg-gray-50 transition-all uppercase tracking-widest">
                            Cancel
                        </a>
                        <button type="submit" class="group relative inline-flex items-center gap-3 px-10 py-4 bg-sisc-purple hover:bg-violet-900 text-white font-black rounded-lg shadow-xl shadow-purple-900/10 hover:shadow-purple-900/20 hover:-translate-y-1 transition-all uppercase tracking-widest text-sm">
                            Initialize Exam
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m5-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">
                Powered by CAPSAT Assessment Engine
            </div>
        </div>
    </div>
</x-app-layout>

