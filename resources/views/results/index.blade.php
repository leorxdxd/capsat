<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Exam Results - Pending Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Desktop Table --}}
                    <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sisc-purple text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Last Activity</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($results as $result)
                                    <tr class="transition-colors border-b border-gray-50 last:border-0" 
                                        style="--hover-bg: color-mix(in srgb, var(--sisc-purple), transparent 95%);" 
                                        onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" 
                                        onmouseout="this.style.backgroundColor=''">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $result->student->first_name }} {{ $result->student->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $result->created_at->format('M d, Y') }} ({{ $result->exam->title }})
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                                {{ $result->status === 'returned' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                                {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                            <a href="{{ route('results.show', $result) }}" class="text-sisc-purple transition-all hover:underline"
                                               style="--hover-color: color-mix(in srgb, var(--sisc-purple), black 20%);"
                                               onmouseover="this.style.color=this.style.getPropertyValue('--hover-color')"
                                               onmouseout="this.style.color=''">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="font-medium">No results pending review.</p>
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
                            <a href="{{ route('results.show', $result) }}" class="block bg-white rounded-lg p-5 shadow-sm border border-gray-100 hover:border-sisc-purple transition-all hover:shadow-md">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="font-bold text-gray-900 text-sm">
                                        {{ $result->student->first_name }} {{ $result->student->last_name }}
                                    </p>
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                        {{ $result->status === 'returned' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                        {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-gray-500 mb-0 font-medium uppercase tracking-wide">
                                        Last Activity: {{ $result->created_at->format('M d, Y') }}
                                    </p>
                                    <span class="text-sisc-purple text-xs font-bold hover:underline">Review Profile &rarr;</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12 from-gray-50 to-white bg-gradient-to-b rounded-lg border border-gray-100">
                                <svg class="w-12 h-12 text-gray-300 mb-3 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-gray-500 font-medium">No results pending review.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

