<x-app-layout :sidebarCollapsed="true">
    <div class="min-h-screen bg-gray-50 pb-24" x-data="examTaker()">
        <!-- ═══════════════════════════════════════════
             STICKY HEADER — Timer + Progress
             ═══════════════════════════════════════════ -->
        <div class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
                <div class="flex justify-between items-center gap-3">
                    <!-- Left: Exam Info -->
                    <div class="min-w-0 flex-1">
                        <h1 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $exam->title }}</h1>
                        <p class="text-xs text-gray-500 mt-0.5">
                            <span x-text="answeredCount" class="font-bold text-sisc-purple"></span> of <span x-text="totalQuestions"></span> answered
                        </p>
                    </div>

                    <!-- Right: Timer -->
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="px-3 sm:px-4 py-2 rounded-lg font-mono text-lg sm:text-xl font-bold flex items-center gap-2"
                             :class="timeLeft > 0 && timeLeft <= 300 ? 'bg-red-50 text-red-600 border border-red-200 animate-pulse' : 'bg-purple-50 text-sisc-purple border border-purple-100'">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span x-text="timeDisplay"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="h-1.5 w-full bg-gray-100">
                <div class="h-full bg-gradient-to-r from-sisc-purple to-violet-500 transition-all duration-500 ease-out rounded-r-full shadow-sm" :style="`width: ${progress}%`"></div>
            </div>

            <!-- Review Mode Banner -->
            <div x-show="reviewMode" x-cloak class="bg-amber-500 text-white px-4 py-2 text-center text-sm font-bold animate-pulse">
                REVIEW MODE: Please double check your answers before clicking "Finalize & Submit".
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- ═════════════════════════════════
                     LEFT: QUESTION NAVIGATOR (Sticky)
                     ═════════════════════════════════ -->
                <div class="lg:w-72 flex-shrink-0">
                    <div class="sticky top-24 space-y-4">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                    Question Navigator
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-5 gap-2">
                                    @php $navQ = 0; @endphp
                                    @foreach($exam->sections as $section)
                                        @foreach($section->questions as $question)
                                            @php $navQ++; @endphp
                                            <button @click="scrollToQuestion('question-{{ $question->id }}')"
                                                    type="button"
                                                    class="h-10 text-xs font-bold rounded-lg border-2 transition-all duration-200 flex items-center justify-center"
                                                    :class="isAnswered('answers[{{ $question->id }}]') 
                                                        ? 'bg-sisc-purple text-white border-sisc-purple shadow-md' 
                                                        : 'bg-white text-gray-400 border-gray-100 hover:border-purple-200 hover:bg-purple-50'">
                                                {{ $navQ }}
                                            </button>
                                        @endforeach
                                    @endforeach
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                                    <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                                        <span class="w-3 h-3 bg-sisc-purple rounded shadow-sm"></span>
                                        <span>Answered</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                                        <span class="w-3 h-3 bg-white border-2 border-gray-100 rounded"></span>
                                        <span>Not yet answered</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mini Submit Action -->
                        <div class="bg-indigo-600 rounded-lg p-4 shadow-lg text-white">
                            <p class="text-[10px] font-bold uppercase tracking-wider opacity-80 mb-2 text-center text-white/90" x-text="reviewMode ? 'Final Check' : 'Finish Exam'"></p>
                            <button x-show="!reviewMode" type="button" @click="enterReviewMode()"
                                    class="w-full bg-white text-indigo-700 font-black py-2.5 rounded-lg shadow-sm hover:bg-gray-50 transition-colors text-sm">
                                REVIEW ANSWERS
                            </button>
                            <button x-show="reviewMode" x-cloak type="button" @click="confirmSubmit()"
                                    class="w-full bg-amber-400 text-amber-900 font-black py-2.5 rounded-lg shadow-sm hover:bg-amber-300 transition-colors text-sm">
                                FINALIZE & SUBMIT
                            </button>
                            <button x-show="reviewMode" x-cloak type="button" @click="reviewMode = false"
                                    class="w-full mt-2 text-white/80 font-bold py-1 text-xs hover:text-white transition-colors underline">
                                Back to Editing
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ═════════════════════════════════
                     RIGHT: EXAM CONTENT
                     ═════════════════════════════════ -->
                <div class="flex-1">
                    <form id="examForm" method="POST" action="{{ route('student.exams.submit', $attempt) }}" class="space-y-8">
                        @csrf

            @php $globalQ = 0; @endphp


            @foreach($exam->sections as $sectionIndex => $section)
                <!-- ═════════════════════════════════
                     SECTION HEADER
                     ═════════════════════════════════ -->
                <div class="rounded-lg overflow-hidden shadow-sm border border-gray-200 bg-white">

                    <!-- Section Title Bar -->
                    <div class="px-5 sm:px-6 py-4 bg-gradient-to-r
                        @if($sectionIndex % 5 === 0) from-sisc-purple to-violet-600
                        @elseif($sectionIndex % 5 === 1) from-violet-600 to-fuchsia-600
                        @elseif($sectionIndex % 5 === 2) from-fuchsia-600 to-pink-600
                        @elseif($sectionIndex % 5 === 3) from-pink-600 to-rose-600
                        @else from-rose-600 to-orange-600
                        @endif text-white">
                        <div class="flex items-center gap-3">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-white/20">
                                Section {{ $sectionIndex + 1 }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight">{{ $section->title }}</h2>
                        </div>
                        @if($section->description)
                            <p class="text-white/90 text-sm mt-2 ml-1">{{ $section->description }}</p>
                        @endif
                    </div>

                    <!-- Section Instructions -->
                    @if($section->instructions)
                        <div class="mx-4 sm:mx-6 mt-4 mb-2 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <p class="text-sm font-bold text-blue-800 mb-1">Instructions</p>
                                    <p class="text-sm text-blue-800/90 leading-relaxed">{{ $section->instructions }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Questions -->
                    <div class="px-4 sm:px-6 py-4 space-y-6">
                        @foreach($section->questions as $qIndex => $question)
                            @php $globalQ++; @endphp

                            <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}" id="question-{{ $question->id }}">

                                <!-- Question Header: Number + Text -->
                                <div class="flex items-start gap-3 sm:gap-4 mb-4">
                                    <!-- Big number circle -->
                                    <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-sm sm:text-base font-bold shadow-sm
                                        @if($sectionIndex % 5 === 0) bg-indigo-50 text-indigo-700 border border-indigo-100
                                        @elseif($sectionIndex % 5 === 1) bg-violet-50 text-violet-700 border border-violet-100
                                        @elseif($sectionIndex % 5 === 2) bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-100
                                        @elseif($sectionIndex % 5 === 3) bg-pink-50 text-pink-700 border border-pink-100
                                        @else bg-rose-50 text-rose-700 border border-rose-100
                                        @endif">
                                        {{ $loop->iteration }}
                                    </div>

                                    <!-- Question Content -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base sm:text-lg text-gray-900 font-semibold leading-relaxed" style="white-space: pre-wrap;">{{ $question->content }}</p>

                                        @if($question->media_url)
                                            <div class="mt-3">
                                                <img src="{{ $question->media_url }}" alt="Question Image" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Answer Options -->
                                <div class="ml-0 sm:ml-14">

                                    {{-- ══════════ MULTIPLE CHOICE ══════════ --}}
                                    @if($question->type === 'multiple_choice' || $question->type === 'analogy' || $question->type === 'sequence')
                                        <div class="space-y-2">
                                            @foreach($question->options as $optIndex => $option)
                                                @php
                                                    $optionText = is_array($option) ? ($option['text'] ?? '') : $option;
                                                @endphp
                                                @if(!empty($optionText))
                                                    <label class="group flex items-center gap-3 p-3 sm:p-4 rounded-lg border-2 cursor-pointer transition-all duration-200
                                                        border-gray-200 hover:border-sisc-purple/50 hover:bg-purple-50/50
                                                        has-[:checked]:border-sisc-purple has-[:checked]:bg-purple-50
                                                        has-[:checked]:shadow-sm">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionText }}"
                                                               class="sr-only peer" @change="updateProgress()">

                                                        <!-- Letter circle -->
                                                        <span class="flex-shrink-0 w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-200
                                                            bg-gray-100 text-gray-500
                                                            group-hover:bg-purple-100 group-hover:text-sisc-purple
                                                            peer-checked:bg-sisc-purple peer-checked:text-white">
                                                            {{ chr(65 + $optIndex) }}
                                                        </span>

                                                        <!-- Option content -->
                                                        <div class="flex-1 min-w-0">
                                                            @if(isset($question->option_images[$optIndex]))
                                                                <img src="{{ $question->option_images[$optIndex] }}" alt="Option {{ chr(65 + $optIndex) }}" class="max-w-[180px] sm:max-w-[220px] h-auto rounded-lg border border-gray-200 mb-1.5">
                                                            @endif
                                                            <span class="text-sm sm:text-base text-gray-700 peer-checked:text-gray-900 peer-checked:font-bold leading-relaxed">
                                                                {{ $optionText }}
                                                            </span>
                                                        </div>

                                                        <!-- Checkmark (visible when selected) -->
                                                        <svg class="w-5 h-5 ml-auto flex-shrink-0 text-sisc-purple opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>

                                    {{-- ══════════ TRUE / FALSE ══════════ --}}
                                    @elseif($question->type === 'true_false')
                                        <div class="grid grid-cols-2 gap-3">
                                            @foreach(['True', 'False'] as $tfi => $opt)
                                                <label class="group relative flex items-center justify-center p-4 sm:p-5 rounded-lg border-2 cursor-pointer transition-all duration-200
                                                    border-gray-200 hover:border-sisc-purple/50 hover:bg-purple-50/50
                                                    has-[:checked]:border-sisc-purple has-[:checked]:bg-purple-50
                                                    has-[:checked]:shadow-sm">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"
                                                           class="sr-only peer" @change="updateProgress()">
                                                    <div class="text-center">
                                                        <span class="block text-2xl mb-1">{{ $tfi === 0 ? '✓' : '✗' }}</span>
                                                        <span class="text-sm sm:text-base font-semibold text-gray-600 peer-checked:text-sisc-purple transition-colors">{{ $opt }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                    {{-- ══════════ IDENTIFICATION / NUMBER SERIES / TEXT ══════════ --}}
                                    @else
                                        <div class="relative">
                                            <input type="text" name="answers[{{ $question->id }}]"
                                                   class="w-full px-4 py-3 sm:py-3.5 text-base sm:text-lg border-2 border-gray-200 bg-white rounded-lg focus:ring-4 focus:ring-purple-100 focus:border-sisc-purple transition-all placeholder:text-gray-400 font-medium text-gray-900"
                                                   placeholder="{{ $question->type === 'number_series' ? 'Enter the number...' : 'Type your answer here...' }}"
                                                   @input="updateProgress()">
                                            @if($question->type === 'number_series')
                                                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- ═══════════════════════════════════
                 SUBMIT/REVIEW BUTTON
                 ═══════════════════════════════════ -->
            <div class="pt-4 pb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 sm:p-6 sticky bottom-4 z-40 transition-all"
                     :class="reviewMode ? 'ring-4 ring-amber-400 border-amber-500' : ''">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-bold text-gray-900" x-text="answeredCount"></span> of
                                <span class="font-bold text-gray-900" x-text="totalQuestions"></span> questions answered
                            </p>
                            <p class="text-xs text-amber-600 mt-1 font-medium" x-show="answeredCount < totalQuestions && !reviewMode">
                                * Please review unanswered items before submitting
                            </p>
                            <p class="text-xs text-emerald-600 mt-1 font-bold" x-show="reviewMode" x-cloak>
                                ✓ Review mode active. Scroll up to check your answers.
                            </p>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button x-show="!reviewMode" type="button" @click="enterReviewMode()"
                                    class="w-full sm:w-auto bg-gradient-to-r from-sisc-purple to-violet-800 hover:from-indigo-900 hover:to-purple-900 text-white text-base font-bold py-3.5 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Review Responses
                            </button>
                            
                            <button x-show="reviewMode" x-cloak type="button" @click="confirmSubmit()"
                                    class="w-full sm:w-auto bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white text-base font-bold py-3.5 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Finalize & Submit
                            </button>
                            
                            <button x-show="reviewMode" x-cloak type="button" @click="reviewMode = false"
                                    class="w-full sm:w-auto bg-gray-100 text-gray-700 font-bold py-3.5 px-6 rounded-lg border border-gray-200 hover:bg-gray-200 transition-all">
                                Edit Answers
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function examTaker() {
            return {
                timeLeft: {{ $remainingSeconds ?? -1 }},
                totalQuestions: {{ $exam->questions()->count() ?? 0 }},
                answeredCount: 0,
                answeredAnswers: {},
                reviewMode: false,

                get timeDisplay() {
                    if (this.timeLeft === -1) return "No Limit";
                    const h = Math.floor(this.timeLeft / 3600);
                    const m = Math.floor((this.timeLeft % 3600) / 60);
                    const s = this.timeLeft % 60;
                    if (h > 0) return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                    return `${m}:${s.toString().padStart(2, '0')}`;
                },

                get progress() {
                    return this.totalQuestions > 0 ? (this.answeredCount / this.totalQuestions) * 100 : 0;
                },

                init() {
                    const interval = setInterval(() => {
                        if (this.timeLeft === -1) return;
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            clearInterval(interval);
                            this.autoSubmit();
                        }
                    }, 1000);

                    window.onbeforeunload = function() {
                        return "Are you sure you want to leave? Your exam progress might be lost.";
                    };
                    
                    this.updateProgress();
                },

                updateProgress() {
                    const answersMap = {};
                    document.querySelectorAll('input[type="radio"]:checked, input[type="text"]').forEach(input => {
                        if (input.type === 'text' && input.value.trim() === '') return;
                        answersMap[input.name] = true;
                    });
                    this.answeredAnswers = answersMap;
                    this.answeredCount = Object.keys(answersMap).length;
                },

                isAnswered(name) {
                    return !!this.answeredAnswers[name];
                },

                scrollToQuestion(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        const offset = 100; // Header height approx
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = el.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                },

                enterReviewMode() {
                    this.reviewMode = true;
                    // Scroll to top to start review
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                confirmSubmit() {
                    if (confirm('Are you sure you want to submit your exam? You cannot undo this action.')) {
                        this.submitForm();
                    }
                },

                autoSubmit() {
                    alert('Time is up! Your exam is being submitted automatically.');
                    this.submitForm();
                },

                submitForm() {
                    window.onbeforeunload = null;
                    document.getElementById('examForm').submit();
                }
            }
        }
    </script>
</x-app-layout>

