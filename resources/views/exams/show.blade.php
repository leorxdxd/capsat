<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                    {{ $exam->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $exam->target_grade_level ?? 'All Grades' }} · {{ $exam->time_limit ? $exam->time_limit . ' minutes' : 'Unlimited time' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('exams.edit', $exam) }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="hidden sm:inline">Edit Details</span>
                </a>
                <a href="{{ route('exams.preview', $exam) }}" target="_blank" class="bg-purple-50 hover:bg-purple-100 text-sisc-purple border border-purple-100 px-4 py-2 rounded-lg text-sm font-bold transition-colors flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span class="hidden sm:inline">Preview</span>
                </a>
                <a href="{{ route('exams.index') }}" class="text-gray-500 hover:text-sisc-purple flex items-center text-sm font-bold gap-1 transition-colors px-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="hidden sm:inline">All Exams</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-3.5 rounded-lg flex items-center gap-3 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- ═══════════════════════════════════
                 EXAM OVERVIEW
                 ═══════════════════════════════════ -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-6 py-4 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
                    <div class="relative flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Exam Overview
                            </h3>
                            @if($exam->description)
                                <p class="text-purple-100 text-sm mt-1 ml-7">{{ $exam->description }}</p>
                            @endif
                        </div>
                        <span class="px-3 py-1 text-sm font-bold rounded-full border {{ $exam->active ? 'bg-white/20 text-white border-transparent' : 'bg-red-50 text-red-600 border-red-100' }}">
                            {{ $exam->active ? '● Active' : '● Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4 sm:gap-6">
                        <div class="text-center bg-purple-50 rounded-lg p-4 border border-purple-100">
                            <p class="text-2xl sm:text-3xl font-extrabold text-sisc-purple">{{ $exam->sections->count() }}</p>
                            <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wide mt-1">Sections</p>
                        </div>
                        <div class="text-center bg-amber-50 rounded-lg p-4 border border-amber-100">
                            <p class="text-2xl sm:text-3xl font-extrabold text-sisc-gold">{{ $totalQuestions }}</p>
                            <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wide mt-1">Questions</p>
                        </div>
                        <div class="text-center bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-2xl sm:text-3xl font-extrabold text-gray-700">{{ $totalPoints }}</p>
                            <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wide mt-1">Total Points</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════
                 SECTIONS & QUESTIONS
                 ═══════════════════════════════════ -->
            @php
                // Updated colors to be lighter/cleaner for SISC theme
                $sectionColors = [
                    ['from-violet-600 to-purple-600', 'bg-violet-50', 'border-violet-100', 'text-violet-700', 'ring-violet-500'],
                    ['from-purple-600 to-fuchsia-600', 'bg-purple-50', 'border-purple-100', 'text-purple-700', 'ring-purple-500'],
                    ['from-emerald-500 to-teal-600', 'bg-emerald-50', 'border-emerald-100', 'text-emerald-700', 'ring-emerald-500'],
                    ['from-amber-500 to-orange-500', 'bg-amber-50', 'border-amber-100', 'text-amber-700', 'ring-amber-500'],
                    ['from-blue-600 to-indigo-600', 'bg-blue-50', 'border-blue-100', 'text-blue-700', 'ring-blue-500'],
                ];
            @endphp

            @foreach($exam->sections as $sectionIndex => $section)
                @php $sc = $sectionColors[$sectionIndex % 5]; @endphp

                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100" id="section-{{ $section->id }}">
                    <!-- Section Header -->
                    <div class="bg-gradient-to-r {{ $sc[0] }} px-5 sm:px-6 py-4">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide backdrop-blur-sm">Section {{ $sectionIndex + 1 }}</span>
                                    <h3 class="text-lg font-bold text-white truncate">{{ $section->title }}</h3>
                                    <span class="bg-black/20 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide border border-white/10">{{ $section->section_type ?? 'Intelligence' }}</span>
                                </div>
                                @if($section->description)
                                    <p class="text-white/80 text-sm mt-1.5 font-medium">{{ $section->description }}</p>
                                @endif
                                @if($section->instructions)
                                    <p class="text-white/60 text-xs mt-1 italic">📋 {{ $section->instructions }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 flex-shrink-0 ml-2">
                                <span class="bg-white/10 text-white text-xs font-bold px-2 py-1 rounded hidden sm:inline">{{ $section->questions->count() }} Questions</span>
                                <button @click="editSection = {{ $section->id }}" class="text-white/70 hover:text-white p-2 transition-colors rounded-lg hover:bg-white/20" title="Edit Section">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form method="POST" action="{{ route('exams.sections.destroy', [$exam, $section]) }}" onsubmit="return confirm('Delete this section and all its questions?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-white/70 hover:text-red-200 p-2 transition-colors rounded-lg hover:bg-white/20" title="Delete Section">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Section Form -->
                    <div x-show="editSection === {{ $section->id }}" x-cloak class="{{ $sc[1] }} px-5 sm:px-6 py-4 border-b {{ $sc[2] }}">
                        <form method="POST" action="{{ route('exams.sections.update', [$exam, $section]) }}" class="space-y-3">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <input type="text" name="title" value="{{ $section->title }}" placeholder="Section Title" required class="border-gray-300 rounded-none text-sm focus:ring-2 focus:{{ $sc[4] }} focus:border-{{ $sc[4] }}">
                                <input type="text" name="description" value="{{ $section->description }}" placeholder="Description (optional)" class="border-gray-300 rounded-none text-sm focus:ring-2 focus:{{ $sc[4] }} focus:border-{{ $sc[4] }}">
                                <input type="text" name="instructions" value="{{ $section->instructions }}" placeholder="Instructions (optional)" class="border-gray-300 rounded-none text-sm focus:ring-2 focus:{{ $sc[4] }} focus:border-{{ $sc[4] }}">
                                <select name="section_type" class="border-gray-300 rounded-none text-sm focus:ring-2 focus:{{ $sc[4] }} focus:border-{{ $sc[4] }}">
                                    <option value="intelligence" {{ ($section->section_type ?? 'intelligence') === 'intelligence' ? 'selected' : '' }}>Intelligence Profile</option>
                                    <option value="achievement" {{ ($section->section_type ?? 'intelligence') === 'achievement' ? 'selected' : '' }}>Achievement Profile</option>
                                    <option value="other" {{ ($section->section_type ?? 'intelligence') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-gradient-to-r {{ $sc[0] }} text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-sm">Update Section</button>
                                <button type="button" @click="editSection = null" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-bold transition-colors">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Questions -->
                    <div class="divide-y divide-gray-100">
                        @foreach($section->questions as $qIndex => $question)
                            <div class="p-5 sm:p-6 hover:bg-gray-50 transition-colors group">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <!-- Question Number -->
                                    <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 {{ $question->number_class }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $qIndex + 1 }}
                                    </div>

                                    <!-- Question Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $question->badge_class }} border border-transparent">
                                                {{ $question->type_label }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-medium">{{ $question->points }} {{ Str::plural('point', $question->points) }}</span>
                                        </div>

                                        <p class="text-gray-900 font-medium mb-2 text-sm sm:text-base leading-relaxed" style="white-space: pre-wrap;">{{ $question->content }}</p>

                                        @if($question->media_url)
                                            <div class="mb-3">
                                                <img src="{{ $question->media_url }}" alt="Question Image" class="max-w-xs h-auto rounded-lg border border-gray-200 shadow-sm">
                                            </div>
                                        @endif

                                        @if($question->options && count($question->options) > 0)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                                                @foreach($question->options as $optIndex => $option)
                                                    @php
                                                        $isCorrect = false;
                                                        $optionText = '';
                                                        
                                                        // Handle both simple string options (old) and structured options (new)
                                                        if (is_array($option)) {
                                                            $optionText = $option['text'] ?? '';
                                                            $isCorrect = $option['is_correct'] ?? false;
                                                        } else {
                                                            $optionText = $option;
                                                            $isCorrect = $option === $question->correct_answer;
                                                        }
                                                    @endphp
                                                    <div class="flex items-start gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                                                        {{ $isCorrect ? 'bg-emerald-50 text-emerald-900 font-semibold border border-emerald-100' : 'bg-white border border-gray-100 text-gray-600' }}">
                                                        <span class="font-mono text-xs font-bold {{ $isCorrect ? 'text-emerald-600' : 'text-gray-400' }} mt-0.5">{{ chr(65 + $optIndex) }}.</span>
                                                        <div class="flex-1">
                                                            @if(isset($question->option_images[$optIndex]))
                                                                <img src="{{ $question->option_images[$optIndex] }}" alt="Option {{ chr(65 + $optIndex) }}" class="max-w-[120px] h-auto rounded border border-gray-200 mb-1">
                                                            @endif
                                                            {{ $optionText }}
                                                        </div>
                                                        @if($isCorrect)
                                                            <svg class="w-4 h-4 ml-auto text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="text-xs text-gray-500 font-bold uppercase tracking-wide">Answer:</span>
                                                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded text-sm font-bold border border-emerald-100">{{ $question->correct_answer }}</span>
                                            </div>
                                        @endif

                                        @if($question->explanation)
                                            <div class="mt-3 flex gap-2 text-sm bg-blue-50 p-3 rounded-lg border border-blue-100 text-blue-800">
                                                <span class="text-blue-500">💡</span>
                                                <span class="italic text-xs sm:text-sm">{{ $question->explanation }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Question Actions -->
                                    <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                                        <button @click="editQuestion = {{ $question->id }}" class="text-gray-400 hover:text-sisc-purple p-1.5 rounded-lg hover:bg-purple-50 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form method="POST" action="{{ route('exams.questions.destroy', [$exam, $section, $question]) }}" onsubmit="return confirm('Delete this question?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Question Form (inline) -->
                                <div x-show="editQuestion === {{ $question->id }}" x-cloak class="mt-4 p-5 {{ $sc[1] }} rounded-lg border {{ $sc[2] }}">
                                    <form method="POST" action="{{ route('exams.questions.update', [$exam, $section, $question]) }}" class="space-y-4" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Type</label>
                                                <select name="type" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                                    @foreach(['multiple_choice' => 'Multiple Choice', 'true_false' => 'True or False', 'identification' => 'Identification', 'number_series' => 'Number Series', 'analogy' => 'Analogy', 'sequence' => 'Sequence'] as $val => $label)
                                                        <option value="{{ $val }}" {{ $question->type === $val ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Points</label>
                                                <input type="number" name="points" value="{{ $question->points }}" min="1" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Correct Answer</label>
                                                <input type="text" name="correct_answer" value="{{ $question->correct_answer }}" required class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Question Content</label>
                                            <textarea name="content" rows="3" required class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple" placeholder="Enter question text...">{{ $question->content }}</textarea>
                                        </div>
                                        {{-- Question Image Upload --}}
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">📷 Question Image</label>
                                            @if($question->media_url)
                                                <div class="flex items-center gap-3 mb-2">
                                                    <img src="{{ $question->media_url }}" alt="Current Image" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                                    <label class="flex items-center gap-1.5 text-xs text-red-500 cursor-pointer font-bold">
                                                        <input type="checkbox" name="remove_media" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                                        Remove
                                                    </label>
                                                </div>
                                            @endif
                                            <input type="file" name="media" accept="image/*" class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-sisc-purple hover:file:bg-purple-200 transaction-colors">
                                            <p class="text-xs text-gray-400 mt-1">Max 5MB. Supports JPG, PNG, GIF, WEBP</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Options (for multiple choice — one per field)</label>
                                            <div class="space-y-2">
                                                @for($i = 0; $i < 5; $i++)
                                                    <div class="flex items-start gap-2">
                                                        <span class="text-xs font-bold text-gray-400 mt-2.5 w-5">{{ chr(65 + $i) }}.</span>
                                                        <div class="flex-1 space-y-1">
                                                            <input type="text" name="options[]" value="{{ is_array($question->options[$i] ?? null) ? ($question->options[$i]['text'] ?? '') : ($question->options[$i] ?? '') }}" placeholder="Option {{ chr(65 + $i) }}" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                                            <div class="flex items-center gap-2">
                                                                @if(isset($question->option_images[$i]))
                                                                    <img src="{{ $question->option_images[$i] }}" alt="Option {{ chr(65 + $i) }} Image" class="w-12 h-12 object-cover rounded border border-gray-200">
                                                                    <label class="flex items-center gap-1 text-xs text-red-500 cursor-pointer font-bold">
                                                                        <input type="checkbox" name="remove_option_images[{{ $i }}]" value="1" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                                                        Remove
                                                                    </label>
                                                                @endif
                                                                <input type="file" name="option_image_files[{{ $i }}]" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Explanation (optional)</label>
                                            <input type="text" name="explanation" value="{{ $question->explanation }}" placeholder="Why this is the correct answer..." class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-5 py-2 rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md">Save Changes</button>
                                            <button type="button" @click="editQuestion = null" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-bold rounded-lg transition-colors">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        @if($section->questions->isEmpty())
                            <div class="p-10 text-center text-gray-500">
                                <div class="w-16 h-16 mx-auto mb-4 bg-gray-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="font-bold text-gray-900">No questions yet</p>
                                <p class="text-sm mt-1">Get started by adding questions below.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Add Question Form -->
                    <div class="border-t border-gray-100 bg-gray-50 p-5 sm:p-6">
                        <button @click="addingQuestion === {{ $section->id }} ? addingQuestion = null : addingQuestion = {{ $section->id }}"
                                class="w-full text-center py-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-sisc-purple hover:bg-purple-50 transition-all text-gray-500 hover:text-sisc-purple font-bold text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Question to {{ $section->title }}
                        </button>

                        <div x-show="addingQuestion === {{ $section->id }}" x-cloak class="mt-6" x-data="{ qType: 'multiple_choice' }">
                            <form method="POST" action="{{ route('exams.questions.store', [$exam, $section]) }}" class="space-y-5 bg-white rounded-lg p-6 border border-gray-200 shadow-sm" enctype="multipart/form-data">
                                @csrf
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="p-2 bg-purple-100 rounded-lg text-sisc-purple">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-xl text-gray-900">New Question</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Question Type <span class="text-red-500">*</span></label>
                                        <select name="type" x-model="qType" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="true_false">True or False</option>
                                            <option value="identification">Identification</option>
                                            <option value="number_series">Number Series (Math)</option>
                                            <option value="analogy">Analogy</option>
                                            <option value="sequence">Sequence</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Points <span class="text-red-500">*</span></label>
                                        <input type="number" name="points" value="1" min="1" required class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Correct Answer <span class="text-red-500">*</span></label>
                                        <input type="text" name="correct_answer" required class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple"
                                               :placeholder="qType === 'true_false' ? 'True or False' : (qType === 'number_series' ? 'e.g. 10' : (qType === 'multiple_choice' ? 'Must match one option exactly' : 'Enter the answer'))">
                                    </div>
                                </div>

                                <!-- Type Hints -->
                                <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-800 border border-blue-100 flex gap-3">
                                    <span class="text-blue-500 text-lg">💡</span>
                                    <div>
                                        <template x-if="qType === 'multiple_choice'">
                                            <p><strong>Multiple Choice (OLSAT/MAT):</strong> Standard aptitude test format. Enter a question stem and up to 5 answer choices (A–E). The correct answer must exactly match one option.</p>
                                        </template>
                                        <template x-if="qType === 'true_false'">
                                            <p><strong>True or False:</strong> Enter a statement. The correct answer should be "True" or "False".</p>
                                        </template>
                                        <template x-if="qType === 'identification'">
                                            <p><strong>Identification:</strong> The student types a short answer. Common in vocabulary and comprehension sections.</p>
                                        </template>
                                        <template x-if="qType === 'number_series'">
                                            <p><strong>Number Series (Quantitative Reasoning):</strong> Enter a number pattern like "2, 4, 6, 8, __". The student finds the missing number. Core OLSAT/MAT item type.</p>
                                        </template>
                                        <template x-if="qType === 'analogy'">
                                            <p><strong>Analogy (Verbal/Figural Reasoning):</strong> "Cat is to Kitten as Dog is to __". A key OLSAT item type testing relational thinking. Provide answer options.</p>
                                        </template>
                                        <template x-if="qType === 'sequence'">
                                            <p><strong>Sequence:</strong> Items that need ordering. Tests logical sequencing ability — common in MAT assessments.</p>
                                        </template>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Question Content <span class="text-red-500">*</span></label>
                                    <textarea name="content" rows="3" required
                                              class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple"
                                              :placeholder="qType === 'number_series' ? 'e.g. What comes next: 2, 4, 8, 16, __?' : (qType === 'analogy' ? 'e.g. Cat is to Kitten as Dog is to __' : (qType === 'true_false' ? 'Enter a true/false statement...' : 'Enter the question text...'))"></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Tip: For math, use symbols directly (×, ÷, +, −, =, √). For fractions, use slash notation (1/2, 3/4).</p>
                                </div>

                                {{-- Question Image Upload --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">📷 Question Image (optional)</label>
                                    <input type="file" name="media" accept="image/*" class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                    <p class="text-xs text-gray-400 mt-1">Upload a figure, diagram, or picture for this question. Max 5MB.</p>
                                </div>

                                <!-- Options (shown conditionally) -->
                                <div x-show="qType === 'multiple_choice' || qType === 'analogy' || qType === 'sequence'">
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Answer Choices (A–E, leave unused blank)</label>
                                    <div class="space-y-3">
                                        @for($oi = 0; $oi < 5; $oi++)
                                            <div class="flex items-start gap-2">
                                                <span class="text-xs font-bold text-gray-400 mt-2.5 w-5">{{ chr(65 + $oi) }}.</span>
                                                <div class="flex-1 space-y-1">
                                                    <input type="text" name="options[]" placeholder="Option {{ chr(65 + $oi) }}{{ $oi === 4 ? ' (optional)' : '' }}" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                                    <input type="file" name="option_image_files[{{ $oi }}]" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200">
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- True/False auto-options -->
                                <template x-if="qType === 'true_false'">
                                    <div>
                                        <input type="hidden" name="options[]" value="True">
                                        <input type="hidden" name="options[]" value="False">
                                    </div>
                                </template>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Explanation (optional)</label>
                                    <input type="text" name="explanation" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple" placeholder="Why this is the correct answer...">
                                </div>

                                <div class="flex gap-3 pt-2">
                                    <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                        Add Question
                                    </button>
                                    <button type="button" @click="addingQuestion = null" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-2.5 text-sm font-bold rounded-lg transition-colors">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- ═══════════════════════════════════
                 ADD SECTION — with OLSAT/MAT presets
                 ═══════════════════════════════════ -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <button @click="addingSection = !addingSection"
                        class="w-full px-5 sm:px-6 py-5 text-left hover:bg-purple-50 transition-colors flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-100 text-sisc-purple rounded-lg p-3 group-hover:bg-sisc-purple group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-sisc-purple transition-colors">Add New Section</h3>
                            <p class="text-sm text-gray-500">Create a section for a cognitive area (e.g., Verbal Comprehension, Quantitative Reasoning)</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-gray-400 transition-transform flex-shrink-0" :class="{ 'rotate-180': addingSection }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="addingSection" x-cloak class="px-5 sm:px-6 pb-6 bg-purple-50/50">
                    <!-- Quick presets -->
                    <div class="mb-5 mt-2">
                        <p class="text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">OLSAT / MAT Quick Presets</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="$refs.sTitle.value='Verbal Comprehension'; $refs.sDesc.value='Measures understanding of verbal concepts and vocabulary'; $refs.sInst.value='Read each question carefully. Choose the word or phrase that best completes each sentence or answers the question.'"
                                    class="px-3 py-1.5 text-xs font-bold bg-white text-gray-600 rounded-lg hover:bg-sisc-purple hover:text-white transition-colors border border-gray-200 shadow-sm">
                                Verbal Comprehension
                            </button>
                            <button type="button" @click="$refs.sTitle.value='Verbal Reasoning'; $refs.sDesc.value='Assesses the ability to reason using verbal concepts'; $refs.sInst.value='Look at the relationship between the words. Choose the answer that completes the same relationship.'"
                                    class="px-3 py-1.5 text-xs font-bold bg-white text-gray-600 rounded-lg hover:bg-sisc-purple hover:text-white transition-colors border border-gray-200 shadow-sm">
                                Verbal Reasoning
                            </button>
                            <button type="button" @click="$refs.sTitle.value='Quantitative Reasoning'; $refs.sDesc.value='Evaluates mathematical and numerical aptitude'; $refs.sInst.value='Solve each problem carefully. Choose the best answer or supply the missing number in the series.'"
                                    class="px-3 py-1.5 text-xs font-bold bg-white text-gray-600 rounded-lg hover:bg-sisc-purple hover:text-white transition-colors border border-gray-200 shadow-sm">
                                Quantitative Reasoning
                            </button>
                            <button type="button" @click="$refs.sTitle.value='Figural Reasoning'; $refs.sDesc.value='Tests the ability to reason with geometric shapes and patterns'; $refs.sInst.value='Look at the pattern in the figures. Choose the figure that comes next or completes the pattern.'"
                                    class="px-3 py-1.5 text-xs font-bold bg-white text-gray-600 rounded-lg hover:bg-sisc-purple hover:text-white transition-colors border border-gray-200 shadow-sm">
                                Figural Reasoning
                            </button>
                            <button type="button" @click="$refs.sTitle.value='Pictorial Reasoning'; $refs.sDesc.value='Assesses spatial and visual reasoning skills'; $refs.sInst.value='Study the pictures carefully. Choose the picture that best answers each question.'"
                                    class="px-3 py-1.5 text-xs font-bold bg-white text-gray-600 rounded-lg hover:bg-sisc-purple hover:text-white transition-colors border border-gray-200 shadow-sm">
                                Pictorial Reasoning
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('exams.sections.store', $exam) }}" class="space-y-4 bg-white rounded-lg p-6 border border-gray-200 shadow-lg">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Section Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required x-ref="sTitle"
                                       class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple"
                                       placeholder="e.g. Verbal Comprehension, Quantitative Reasoning">
                            </div>
                            <div>
                                       placeholder="What cognitive skill does this section measure?">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Section Type</label>
                                <select name="section_type" class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple">
                                    <option value="intelligence">Intelligence Profile</option>
                                    <option value="achievement">Achievement Profile</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Instructions for student</label>
                            <textarea name="instructions" rows="2" x-ref="sInst"
                                      class="w-full border-gray-300 rounded-none text-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple"
                                      placeholder="e.g. Read each question carefully and choose the best answer..."></textarea>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md hover:shadow-lg">
                                Add Section
                            </button>
                            <button type="button" @click="addingSection = false" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-2.5 text-sm font-bold rounded-lg transition-colors">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function examBuilder() {
            return {
                addingSection: false,
                addingQuestion: null,
                editSection: null,
                editQuestion: null,
            }
        }
    </script>
</x-app-layout>

