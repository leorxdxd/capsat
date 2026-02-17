<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('Review Result') }}
            </h2>
            <a href="{{ route('results.index') }}" class="font-medium transition-colors"
               style="--hover-color: var(--sisc-purple);"
               onmouseover="this.style.color=this.style.getPropertyValue('--hover-color')"
               onmouseout="this.style.color=''">
                ← Back to Results
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-lg relative shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg relative shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Student Info -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-sisc-purple rounded-full"></span>
                        Student Information
                    </h3>
                    <div class="grid grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Name</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $result->student->first_name }} {{ $result->student->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Age at Exam</p>
                            <p class="font-medium text-gray-900">{{ number_format($result->age_at_exam, 2) }} years</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Grade Level</p>
                            <p class="font-medium text-gray-900">{{ $result->grade_level_at_exam ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Exam</p>
                            <p class="font-medium text-gray-900">{{ $result->exam->title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Results Summary -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-sisc-gold rounded-full"></span>
                        Exam History & Profile
                    </h3>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Exam Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date Taken</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Raw Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">SAI</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stanine</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Percentile</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($allResults as $item)
                                    <tr class="transition-colors" 
                                        style="--hover-bg: color-mix(in srgb, var(--sisc-purple), transparent 95%);" 
                                        onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" 
                                        onmouseout="this.style.backgroundColor=''">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->exam->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-sisc-purple">{{ $item->raw_score }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->sai ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->stanine ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->percentile ? $item->percentile . '%' : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $item->performance_description ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No exams found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 p-3 bg-amber-50 text-amber-800 rounded-lg text-sm border border-amber-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        This table shows all exams taken by the student. The official PDF will aggregate these scores into a single profile sheet.
                    </div>
                </div>
            </div>

            <!-- Section Breakdown -->
            @php $sectionScores = $result->getSectionScores(); @endphp
            @if($sectionScores->count() > 0)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-1 h-6 bg-emerald-500 rounded-full"></span>
                            Section Breakdown
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($sectionScores as $score)
                                <div class="p-4 rounded-lg border border-gray-100 bg-gray-50 flex justify-between items-center">
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">{{ $score['title'] }}</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $score['raw_score'] }} / {{ $score['total_items'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-black text-emerald-600">{{ $score['percent_score'] }}%</div>
                                        <p class="text-[10px] font-bold text-emerald-700 uppercase">Proficiency</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Psychometrician Review Section -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-sisc-purple rounded-full"></span>
                        Psychometrician Review
                    </h3>
                    
                    @if($result->status === 'draft' || $result->status === 'returned')
                        <form method="POST" action="{{ route('results.sendToCounselor', $result) }}">
                            @csrf
                            
                            <div class="mb-4">
                                <x-input-label for="recommendation" :value="__('Recommendation')" />
                                <select id="recommendation" name="recommendation" class="block mt-1 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-lg shadow-sm" required>
                                    <option value="">Select Recommendation</option>
                                    <option value="Recommended" {{ old('recommendation', $result->recommendation) == 'Recommended' ? 'selected' : '' }}>Recommended</option>
                                    <option value="Strongly Recommended" {{ old('recommendation', $result->recommendation) == 'Strongly Recommended' ? 'selected' : '' }}>Strongly Recommended</option>
                                    <option value="Needs Intervention" {{ old('recommendation', $result->recommendation) == 'Needs Intervention' ? 'selected' : '' }}>Needs Intervention</option>
                                    <option value="Not Recommended" {{ old('recommendation', $result->recommendation) == 'Not Recommended' ? 'selected' : '' }}>Not Recommended</option>
                                    <option value="For Counseling" {{ old('recommendation', $result->recommendation) == 'For Counseling' ? 'selected' : '' }}>For Counseling</option>
                                </select>
                                <x-input-error :messages="$errors->get('recommendation')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="psychometrician_notes" :value="__('Notes / Remarks')" />
                                <textarea id="psychometrician_notes" name="psychometrician_notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-lg shadow-sm">{{ old('psychometrician_notes', $result->psychometrician_notes) }}</textarea>
                                <x-input-error :messages="$errors->get('psychometrician_notes')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-6 py-2.5 bg-sisc-purple text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5"
                                        style="--hover-bg: color-mix(in srgb, var(--sisc-purple), black 20%);"
                                        onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')"
                                        onmouseout="this.style.backgroundColor=''">
                                    {{ __('Sign & Send to Counselor') }}
                                </button>
                            </div>
                        </form>
                    @elseif($result->status === 'counselor_approved')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h4 class="font-bold text-blue-800 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Final Review
                            </h4>
                            <p class="text-sm text-blue-700 mb-4">
                                The counselor has approved this result. You can now edit the final details before printing.
                            </p>
                            
                            <form method="POST" action="{{ route('results.finalSign', $result) }}">
                                @csrf
                                
                                <div class="mb-4">
                                    <x-input-label for="recommendation" :value="__('Final Recommendation')" />
                                    <select id="recommendation" name="recommendation" class="block mt-1 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-lg shadow-sm" required>
                                        <option value="Recommended" {{ old('recommendation', $result->recommendation) == 'Recommended' ? 'selected' : '' }}>Recommended</option>
                                        <option value="Strongly Recommended" {{ old('recommendation', $result->recommendation) == 'Strongly Recommended' ? 'selected' : '' }}>Strongly Recommended</option>
                                        <option value="Needs Intervention" {{ old('recommendation', $result->recommendation) == 'Needs Intervention' ? 'selected' : '' }}>Needs Intervention</option>
                                        <option value="Not Recommended" {{ old('recommendation', $result->recommendation) == 'Not Recommended' ? 'selected' : '' }}>Not Recommended</option>
                                        <option value="For Counseling" {{ old('recommendation', $result->recommendation) == 'For Counseling' ? 'selected' : '' }}>For Counseling</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="psychometrician_notes" :value="__('Final Notes / Remarks')" />
                                    <textarea id="psychometrician_notes" name="psychometrician_notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-lg shadow-sm">{{ old('psychometrician_notes', $result->psychometrician_notes) }}</textarea>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 hover:bg-emerald-700">
                                        {{ __('Finalize & Make Official') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">Recommendation</p>
                                <p class="font-bold text-gray-900">{{ $result->recommendation ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">Notes</p>
                                <p class="text-gray-700 bg-white p-3 rounded-lg border border-gray-200">{{ $result->psychometrician_notes ?? 'No notes provided.' }}</p>
                            </div>

                            @if($result->status === 'official')
                                <div class="mt-6 border-t pt-6 border-gray-200">
                                    <h3 class="text-lg font-bold mb-4 text-gray-900">Official Result Document</h3>
                                    <div class="border rounded-lg overflow-hidden bg-gray-100 h-[800px] shadow-sm">
                                        <iframe src="{{ route('results.pdf', $result) }}" class="w-full h-full" frameborder="0">
                                            This browser does not support PDFs. Please download the PDF to view it: 
                                            <a href="{{ route('results.pdf.download', $result) }}" class="text-sisc-purple underline transition-all font-bold"
                                               style="--hover-color: color-mix(in srgb, var(--sisc-purple), black 20%);"
                                               onmouseover="this.style.color=this.style.getPropertyValue('--hover-color')"
                                               onmouseout="this.style.color=''">Download PDF</a>
                                        </iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-gray-400 rounded-full"></span>
                        Status & Actions
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 font-semibold mb-2">Current Status</p>
                        <span class="px-3 py-1 text-sm font-bold rounded-full 
                            {{ $result->status === 'official' ? 'bg-emerald-100 text-emerald-800' : 
                               ($result->status === 'returned' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                        </span>
                    </div>
                    
                    @if($result->rejection_reason && $result->status === 'returned')
                        <div class="mb-4 bg-red-50 p-4 rounded-lg border border-red-200">
                            <p class="text-sm text-red-700 font-bold mb-1">Returned by Counselor:</p>
                            <p class="text-red-600 italic">"{{ $result->rejection_reason }}"</p>
                        </div>
                    @endif

                    <div class="flex gap-3">
                        @if($result->canBePrinted())
                            <a href="{{ route('results.pdf', $result) }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ __('View PDF') }}
                            </a>
                            <a href="{{ route('results.pdf.download', $result) }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                {{ __('Download PDF') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-gray-400 rounded-full"></span>
                        Signatures
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-sm text-gray-500 mb-2 font-semibold">Psychometrician</p>
                            @if($result->hasPsychometricianSignature())
                                @php $sig = $result->signatures->where('role', 'psychometrician')->first(); @endphp
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="font-bold text-gray-900">{{ $sig->user->name }}</p>
                                </div>
                                <p class="text-xs text-gray-500">{{ $sig->signed_at->format('M d, Y h:i A') }}</p>
                            @else
                                <p class="text-gray-400 italic">Pending signature</p>
                            @endif
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-sm text-gray-500 mb-2 font-semibold">Counselor</p>
                            @if($result->hasCounselorSignature())
                                @php $sig = $result->signatures->where('role', 'counselor')->first(); @endphp
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="font-bold text-gray-900">{{ $sig->user->name }}</p>
                                </div>
                                <p class="text-xs text-gray-500">{{ $sig->signed_at->format('M d, Y h:i A') }}</p>
                            @else
                                <p class="text-gray-400 italic">Pending signature</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

