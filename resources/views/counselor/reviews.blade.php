<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Counselor Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-br from-sisc-purple to-violet-900 rounded-lg shadow-2xl p-8 md:p-12 text-white overflow-hidden group">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mr-24 -mt-24 w-80 h-80 rounded-full bg-sisc-gold opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-64 h-64 rounded-full bg-purple-500 opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000 delay-100"></div>
                <div class="absolute inset-0 bg-pattern opacity-5"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-purple-100">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            Action Required
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                            Pending Reviews
                        </h1>
                        <p class="text-purple-100 text-lg max-w-xl leading-relaxed opacity-90">
                            You have <strong class="text-white">{{ $results->count() }} reviews</strong> waiting for your interpretation.
                        </p>
                    </div>
                    
                    <div class="hidden md:block">
                        <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-3 rounded-lg border border-white/10">
                            <div class="text-right">
                                <p class="text-xs text-purple-200 font-bold uppercase tracking-wider">Pipeline</p>
                                <p class="text-2xl font-black">{{ $results->count() }}</p>
                            </div>
                            <div class="h-8 w-px bg-white/20"></div>
                            <div class="w-10 h-10 rounded-full bg-sisc-gold flex items-center justify-center text-sisc-purple">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Helper Alert -->
            @if($results->count() > 0)
                <div class="bg-amber-50 border border-amber-100 text-amber-800 px-6 py-4 rounded-lg flex items-center gap-3 shadow-sm animation-fade-in-up delay-100">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-amber-900">Interpretation Required</p>
                        <p class="text-sm font-medium text-amber-700">Please review and sign these exam results to release them to students.</p>
                    </div>
                </div>
            @endif
        
            <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    {{-- Desktop Table --}}
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-gray-500">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Exam</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Score</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Submitted</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($results as $result)
                                    <tr class="hover:bg-purple-50 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-purple-50 text-sisc-purple flex items-center justify-center font-bold text-sm ring-4 ring-white shadow-sm group-hover:scale-105 transition-transform">
                                                    {{ substr($result->student->first_name, 0, 1) }}
                                                </div>
                                                <span class="font-bold text-gray-900">{{ $result->student->full_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $result->exam->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-black text-gray-900 text-lg">{{ $result->raw_score }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-sm text-gray-500">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $result->updated_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('counselor.show', $result) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-sisc-purple hover:bg-violet-900 text-white text-xs font-bold uppercase tracking-widest rounded-lg transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                                <span>Review</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-20 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-6 animate-bounce-slow">
                                                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-1">All Caught Up!</h3>
                                                <p class="text-gray-500">No pending reviews waiting for your action.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden space-y-4">
                        @forelse($results as $result)
                            <a href="{{ route('counselor.show', $result) }}" class="block bg-white border border-gray-100 rounded-lg p-5 hover:shadow-lg transition-all active:scale-95 relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-2 h-full bg-sisc-gold group-hover:w-3 transition-all"></div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-sisc-purple flex items-center justify-center font-bold">
                                            {{ substr($result->student->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-base leading-tight">
                                                {{ $result->student->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $result->exam->title }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                                    <div class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $result->updated_at->diffForHumans() }}
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-black text-gray-900 text-lg">{{ $result->raw_score }} pts</span>
                                        <span class="bg-sisc-purple text-white p-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                                <p>No pending reviews.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

