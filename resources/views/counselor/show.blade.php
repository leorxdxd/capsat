<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Review Result') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
        
        {{-- ═══════════════════════════════════
             HERO SECTION
             ═══════════════════════════════════ --}}
        <div class="relative bg-gradient-to-br from-sisc-purple to-violet-900 rounded-lg shadow-2xl p-8 md:p-10 text-white overflow-hidden group">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-24 -mt-24 w-80 h-80 rounded-full bg-sisc-gold opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-64 h-64 rounded-full bg-purple-500 opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000 delay-100"></div>
            <div class="absolute inset-0 bg-pattern opacity-5"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('counselor.index') }}" class="group/back flex items-center gap-2 text-purple-200 hover:text-white text-sm font-bold transition-colors">
                            <span class="bg-white/10 p-1 rounded-lg group-hover/back:bg-white/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </span>
                            Back to List
                        </a>
                        @if($result->status === 'counselor_approved')
                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-100 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Approved
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-100 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                Review Pending
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight mb-2">
                            {{ $result->student->full_name }}
                        </h1>
                        <p class="text-purple-100 text-lg opacity-90 font-medium flex items-center gap-2">
                            <span class="opacity-70">Assessment:</span>
                            {{ $result->exam->title }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('counselor.pdf.download', $result) }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-sisc-purple rounded-lg font-bold hover:bg-purple-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group/btn">
                        <svg class="w-5 h-5 mr-2 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- ═══════════════════════════════════
                 LEFT COLUMN
                 ═══════════════════════════════════ --}}
            <div class="space-y-6">
                <!-- Data Overview Card -->
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Profile & Scores</h3>
                        
                        <div class="space-y-6">
                            <!-- Age/Grade -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100/50">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Age</p>
                                    <p class="text-lg font-black text-gray-900">{{ number_format($result->age_at_exam, 1) }} <span class="text-xs font-bold text-gray-400">YRS</span></p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100/50">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Grade</p>
                                    <p class="text-lg font-black text-gray-900">{{ $result->grade_level_at_exam ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <!-- Scores -->
                            <div class="space-y-4">
                                <div class="relative overflow-hidden bg-gradient-to-br from-sisc-purple to-violet-800 rounded-lg p-5 text-white">
                                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full blur-xl -mr-10 -mt-10"></div>
                                    <p class="text-xs font-bold text-purple-200 uppercase tracking-wider mb-1">Raw Score</p>
                                    <p class="text-4xl font-black">{{ $result->raw_score }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-fuchsia-50 p-4 rounded-lg border border-fuchsia-100">
                                        <p class="text-[10px] text-fuchsia-400 font-bold uppercase tracking-wider mb-1">Percentile</p>
                                        <p class="text-xl font-black text-fuchsia-700">{{ $result->percentile ?? '-' }}%</p>
                                    </div>
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                        <p class="text-[10px] text-blue-400 font-bold uppercase tracking-wider mb-1">Description</p>
                                        <p class="text-sm font-bold text-blue-700 leading-tight mt-1">{{ $result->performance_description ?? 'Pending' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Psychometrician Notes (Compact view for context) -->
                @if($result->psychometrician_notes || $result->recommendation)
                    <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-l-4 border-l-sisc-gold border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xs font-bold text-sisc-gold uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                Psychometrician Context
                            </h3>
                            
                            @if($result->recommendation)
                                <div class="bg-amber-50/50 p-4 rounded-lg border border-amber-100/50 mb-4">
                                    <p class="text-gray-900 italic font-medium text-sm leading-relaxed">
                                        "{{ $result->recommendation }}"
                                    </p>
                                </div>
                            @endif

                             @if($result->psychometrician_notes)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Notes</p>
                                    <div class="text-sm text-gray-600 space-y-2 leading-relaxed">
                                        {{ Str::limit($result->psychometrician_notes, 200) }}
                                        @if(strlen($result->psychometrician_notes) > 200)
                                            <button type="button" class="text-sisc-purple font-bold text-xs" onclick="document.getElementById('full-notes').classList.remove('hidden'); this.style.display='none'">Read more</button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- ═══════════════════════════════════
                 RIGHT COLUMN (MAIN ACTIONS)
                 ═══════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Expanded Psychometrician Analysis (If long) -->
                @if(strlen($result->psychometrician_notes) > 200)
                    <div id="full-notes" class="hidden bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 p-6 animate-fade-in-up">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Full Psychometrician Analysis</h3>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $result->psychometrician_notes }}</p>
                    </div>
                @endif

                <!-- Counselor Action Card -->
                <div class="bg-white rounded-lg shadow-2xl shadow-purple-900/10 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-sisc-purple via-violet-500 to-sisc-gold"></div>
                    
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-lg bg-purple-50 text-sisc-purple flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900">Final Review & Approval</h2>
                                <p class="text-gray-500">Provide your expert assessment for the student's record.</p>
                            </div>
                        </div>

                        @if($result->status === 'for_counselor')
                            <form method="POST" action="{{ route('counselor.approve', $result) }}" class="space-y-6">
                                @csrf
                                
                                <div>
                                    <label for="counselor_notes" class="block text-sm font-bold text-gray-700 mb-2">
                                        Recommendations & Interventions <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <textarea id="counselor_notes" name="counselor_notes" required rows="8"
                                            class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-sisc-purple focus:ring-sisc-purple shadow-inner transition-all p-4 leading-relaxed font-medium text-gray-700"
                                            placeholder="Write your comprehensive assessment, counseling notes, and recommended interventions here...">{{ old('counselor_notes') }}</textarea>
                                        <div class="absolute bottom-4 right-4 text-xs font-bold text-gray-400 bg-white/80 px-2 py-1 rounded-md backdrop-blur-sm">
                                            Official Record
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('counselor_notes')" class="mt-2" />
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 mt-6 border-t border-gray-100">
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" type="button" class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            Return to Psychometrician
                                        </button>
                                        
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 mb-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 p-4 z-20">
                                             <h4 class="text-xs font-bold text-gray-900 uppercase mb-2">Reason for Return</h4>
                                             <input form="return-form" type="text" name="rejection_reason" required placeholder="Reason for returning..." class="w-full text-sm rounded-lg border-gray-300 mb-2">
                                             <button form="return-form" type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-lg text-xs">Confirm Return</button>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 border border-transparent rounded-lg shadow-lg shadow-emerald-500/30 text-base font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Approve & Sign Result
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Hidden form for return action -->
                            <form id="return-form" method="POST" action="{{ route('counselor.return', $result) }}" class="hidden">
                                @csrf
                            </form>
                        @else
                            {{-- READ ONLY VIEW --}}
                            <div class="space-y-6">
                                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-6 flex flex-col md:flex-row items-center gap-4 text-center md:text-left">
                                    <div class="bg-white p-3 rounded-full text-emerald-500 shadow-sm ring-4 ring-emerald-100">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-black text-emerald-900">Result Approved & Signed</h4>
                                        <p class="text-sm font-medium text-emerald-700">Digital signature applied by {{ $result->signatures->where('role', 'counselor')->first()->user->name ?? 'You' }} on {{ $result->updated_at->format('F d, Y') }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Your Assessment Notes
                                    </h4>
                                    <div class="bg-gray-50 rounded-lg p-6 text-gray-700 border border-gray-200 leading-relaxed font-medium">
                                        {{ $result->counselor_notes }}
                                    </div>
                                </div>
                                
                                <div class="pt-6 flex justify-end">
                                    <a href="{{ route('counselor.index') }}" class="text-gray-500 font-bold hover:text-sisc-purple transition-colors text-sm">Return to List</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>

