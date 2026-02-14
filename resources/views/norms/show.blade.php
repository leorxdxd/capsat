<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $norm->name }}
            </h2>
            <a href="{{ route('norms.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Tables
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Table Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-2">Table Information</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Exam:</strong> {{ $norm->exam->title }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Description:</strong> {{ $norm->description ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Add New Range Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Add Interpretation Range</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('norms.addRange', $norm) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <div>
                                <x-input-label for="min_age" :value="__('Min Age (yrs)')" />
                                <x-text-input id="min_age" type="number" step="0.01" name="min_age" :value="old('min_age')" required placeholder="14.00" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('min_age')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="max_age" :value="__('Max Age (yrs)')" />
                                <x-text-input id="max_age" type="number" step="0.01" name="max_age" :value="old('max_age')" required placeholder="14.99" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('max_age')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="min_score" :value="__('Min Score')" />
                                <x-text-input id="min_score" type="number" name="min_score" :value="old('min_score')" required placeholder="10" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('min_score')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="max_score" :value="__('Max Score')" />
                                <x-text-input id="max_score" type="number" name="max_score" :value="old('max_score')" required placeholder="20" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('max_score')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="percentile" :value="__('Percentile')" />
                                <x-text-input id="percentile" type="number" name="percentile" :value="old('percentile')" placeholder="25" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('percentile')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Description *')" />
                                <x-text-input id="description" type="text" name="description" :value="old('description')" required placeholder="Low" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Add Range') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Ranges -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Interpretation Ranges</h3>
                    
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Age Range</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Score Range</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Percentile</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($norm->normRanges as $range)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ number_format($range->min_age, 2) }} - {{ number_format($range->max_age, 2) }} yrs
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $range->min_score }} - {{ $range->max_score }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $range->percentile ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $range->description }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <form action="{{ route('norms.deleteRange', [$norm, $range]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this range?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                        No interpretation ranges defined yet. Add one above.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
