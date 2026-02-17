<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-sisc-purple flex items-center gap-2">
                    <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Preview</span>
                    {{ $exam->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Viewing as student · Read-only</p>
            </div>
            <a href="{{ route('exams.show', $exam) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Builder
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-10" x-data="examPreview()">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            {{-- Preview Notice --}}
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                <p class="text-sm text-amber-800 font-medium">You are previewing this exam as a student would see it. You can interact with it, but no answers will be saved.</p>
            </div>

            {{-- Exam Header --}}
            <div class="sticky top-0 z-30 bg-white rounded-lg shadow-md border border-gray-100 px-5 py-4 mb-6">
                <div class="flex justify-between items-center gap-3">
                    <div>
                        <h1 class="text-lg font-bold text-sisc-purple">{{ $exam->title }}</h1>
                        <p class="text-sm text-gray-500 mt-0.5 font-medium">{{ $totalQuestions }} questions · {{ $exam->time_limit ? $exam->time_limit . ' min' : 'No time limit' }}</p>
                    </div>
                    @if($exam->time_limit)
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-mono font-bold text-gray-700" x-text="timerDisplay"></span>
                        </div>
                    @endif
                </div>
                {{-- Progress --}}
                <div class="mt-3">
                    <div class="flex justify-between text-xs text-gray-400 font-bold uppercase tracking-wide mb-1">
                        <span><span x-text="answered"></span> of {{ $totalQuestions }} answered</span>
                        <span x-text="Math.round(progress) + '%'"></span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2">
                        <div class="bg-sisc-purple h-2 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                    </div>
                </div>
            </div>

            {{-- Sections & Questions --}}
            @php $globalQ = 0; @endphp

            @foreach($exam->sections as $sectionIndex => $section)

                {{-- Section Header --}}
                <div class="mt-8 mb-4 {{ $sectionIndex === 0 ? '!mt-0' : '' }}">
                    <div class="bg-purple-50 border border-purple-100 rounded-lg p-4 sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-sisc-purple rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                {{ $sectionIndex + 1 }}
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-purple-900">{{ $section->title }}</h2>
                                @if($section->description)
                                    <p class="text-sm text-purple-700 mt-0.5">{{ $section->description }}</p>
                                @endif
                            </div>
                            <span class="ml-auto text-xs font-bold text-purple-400 uppercase tracking-wide">{{ $section->questions->count() }} {{ Str::plural('item', $section->questions->count()) }}</span>
                        </div>
                        @if($section->instructions)
                            <div class="mt-3 pl-12">
                                <p class="text-sm text-purple-800 italic font-medium">{{ $section->instructions }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Questions --}}
                @foreach($section->questions as $qIndex => $question)
                    @php $globalQ++; @endphp
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-5 sm:p-6 mb-3 hover:shadow-md transition-shadow">
                        {{-- Question --}}
                        <div class="flex items-start gap-3 mb-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-bold text-gray-500">
                                {{ $globalQ }}
                            </span>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <p class="text-base text-gray-900 font-medium leading-relaxed" style="white-space: pre-wrap;">{!! nl2br(e($question->content)) !!}</p>

                                @if($question->media_url)
                                    <div class="mt-3">
                                        <img src="{{ $question->media_url }}" alt="Question image" class="max-w-full sm:max-w-sm h-auto rounded-lg border border-gray-200 shadow-sm" loading="lazy">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Options --}}
                        <div class="ml-0 sm:ml-11">
                            @if($question->type === 'multiple_choice' || $question->type === 'analogy' || $question->type === 'sequence')
                                <div class="space-y-2">
                                    @foreach($question->options as $optIndex => $option)
                                        @php
                                            $optionText = is_array($option) ? ($option['text'] ?? '') : $option;
                                        @endphp
                                        @if(!empty($optionText))
                                            <div class="flex items-start gap-3 p-3 rounded-lg border cursor-pointer transition-all duration-150"
                                                 :class="answers[{{ $question->id }}] === '{{ addslashes($optionText) }}'
                                                    ? 'border-sisc-purple bg-purple-50 shadow-sm ring-1 ring-sisc-purple'
                                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                                 @click="toggleAnswer({{ $question->id }}, '{{ addslashes($optionText) }}')">
                                                <span class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-colors duration-150"
                                                      :class="answers[{{ $question->id }}] === '{{ addslashes($optionText) }}'
                                                          ? 'bg-sisc-purple text-white'
                                                          : 'bg-gray-100 text-gray-500'">
                                                    {{ chr(65 + $optIndex) }}
                                                </span>
                                                <div class="flex-1 min-w-0 pt-0.5">
                                                    @if(isset($question->option_images[$optIndex]))
                                                        <img src="{{ $question->option_images[$optIndex] }}" alt="Option {{ chr(65 + $optIndex) }}" class="max-w-[180px] h-auto rounded-lg border border-gray-200 mb-1.5" loading="lazy">
                                                    @endif
                                                    <span class="text-sm text-gray-700 font-medium">{{ $optionText }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            @elseif($question->type === 'true_false')
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['True', 'False'] as $tfi => $opt)
                                        <div class="flex items-center justify-center p-4 rounded-lg border cursor-pointer transition-all duration-150"
                                             :class="answers[{{ $question->id }}] === '{{ $opt }}'
                                                ? 'border-sisc-purple bg-purple-50 shadow-sm ring-1 ring-sisc-purple'
                                                : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                             @click="toggleAnswer({{ $question->id }}, '{{ $opt }}')">
                                            <span class="text-2xl mr-2">{{ $tfi === 0 ? '✓' : '✗' }}</span>
                                            <span class="text-sm font-bold text-gray-700">{{ $opt }}</span>
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                <input type="text"
                                       class="w-full bg-white border border-gray-300 rounded-lg text-sm px-4 py-3 text-gray-700 focus:outline-none focus:border-sisc-purple focus:ring-2 focus:ring-sisc-purple transition-all shadow-sm"
                                       placeholder="{{ $question->type === 'number_series' ? 'Enter the next number...' : 'Type your answer...' }}"
                                       @input="answers[{{ $question->id }}] = $event.target.value; updateCounts()">
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach

            {{-- Submit Area --}}
            <div class="mt-8 mb-6 bg-white rounded-lg border border-gray-200 p-6 text-center shadow-lg">
                <p class="text-sm text-gray-500 mb-3 font-medium"><span x-text="answered"></span> of {{ $totalQuestions }} answered</p>
                <button disabled class="bg-sisc-purple text-white px-8 py-3 rounded-lg font-bold text-sm opacity-50 cursor-not-allowed shadow-md">
                    Submit Answers
                </button>
                <p class="text-xs text-gray-400 mt-3 font-medium">Preview only — no answers will be recorded.</p>
            </div>

            {{-- Back --}}
            <div class="text-center mb-8">
                <a href="{{ route('exams.show', $exam) }}" class="inline-flex items-center gap-1.5 text-sisc-purple hover:text-violet-900 text-sm font-bold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Exam Builder
                </a>
            </div>
        </div>
    </div>

    <script>
        function examPreview() {
            return {
                answers: {},
                answered: 0,
                progress: 0,
                totalQuestions: {{ $totalQuestions }},
                timerDisplay: '{{ $exam->time_limit ? sprintf("%02d:%02d", $exam->time_limit, 0) : "--:--" }}',

                toggleAnswer(questionId, value) {
                    if (this.answers[questionId] === value) {
                        delete this.answers[questionId];
                    } else {
                        this.answers[questionId] = value;
                    }
                    this.updateCounts();
                },

                updateCounts() {
                    this.answered = Object.keys(this.answers).filter(k => this.answers[k] !== '' && this.answers[k] !== undefined).length;
                    this.progress = this.totalQuestions > 0 ? (this.answered / this.totalQuestions) * 100 : 0;
                },

                init() {
                    @if($exam->time_limit)
                    let seconds = {{ $exam->time_limit * 60 }};
                    setInterval(() => {
                        if (seconds > 0) {
                            seconds--;
                            const m = Math.floor(seconds / 60);
                            const s = seconds % 60;
                            this.timerDisplay = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                        }
                    }, 1000);
                    @endif
                }
            }
        }
    </script>
</x-app-layout>

