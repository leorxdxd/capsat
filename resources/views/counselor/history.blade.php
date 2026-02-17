<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Review History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-br from-blue-900 to-indigo-900 rounded-lg shadow-2xl p-8 md:p-12 text-white overflow-hidden group">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mr-24 -mt-24 w-80 h-80 rounded-full bg-blue-500 opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-64 h-64 rounded-full bg-indigo-500 opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000 delay-100"></div>
                <div class="absolute inset-0 bg-pattern opacity-5"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-blue-100">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            Archive
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                            Review History
                        </h1>
                        <p class="text-blue-100 text-lg max-w-xl leading-relaxed opacity-90">
                            Access your past approvals and released results.
                        </p>
                    </div>
                </div>
            </div>

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
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Performance</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($results as $result)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs group-hover:scale-110 transition-transform">
                                                    {{ substr($result->student->first_name, 0, 1) }}
                                                </div>
                                                <span class="font-bold text-gray-900">{{ $result->student->full_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $result->exam->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-black text-gray-900">{{ $result->raw_score }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $result->performance_description ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center w-fit gap-1.5">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Approved
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('counselor.show', $result) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-all hover:translate-x-1">
                                                <span>View Details</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900">No history found</h3>
                                                <p class="text-gray-500 text-sm mt-1">Past reviewed exams will appear here.</p>
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
                            <a href="{{ route('counselor.show', $result) }}" class="block bg-white border border-gray-100 rounded-lg p-5 shadow-sm hover:shadow-md transition-all active:scale-95">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                            {{ substr($result->student->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $result->student->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $result->exam->title }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 py-3 border-t border-b border-gray-50 mb-3">
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Score</p>
                                        <p class="font-black text-gray-900 text-lg">{{ $result->raw_score }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Performance</p>
                                        <p class="font-bold text-blue-600 text-sm">{{ $result->performance_description ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-1 text-[10px] font-bold rounded bg-emerald-50 text-emerald-700 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Approved
                                    </span>
                                    <span class="text-xs font-bold text-gray-400 flex items-center gap-1 group-hover:text-blue-600 transition-colors">
                                        Details &rarr;
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                                <p>No history found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

