<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Review Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Student Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Student Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium">{{ $result->student->first_name }} {{ $result->student->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Age at Exam</p>
                            <p class="font-medium">{{ number_format($result->age_at_exam, 2) }} years</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Grade Level</p>
                            <p class="font-medium">{{ $result->grade_level_at_exam ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Exam</p>
                            <p class="font-medium">{{ $result->exam->title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Results -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Exam Results</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Raw Score</p>
                            <p class="text-2xl font-bold">{{ $result->raw_score }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Performance Level</p>
                            <p class="text-lg font-semibold text-blue-600">{{ $result->performance_description ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Percentile</p>
                            <p class="text-lg font-semibold">{{ $result->percentile ? $result->percentile . '%' : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($result->psychometrician_notes)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">Psychometrician Notes</p>
                            <p class="mt-1">{{ $result->psychometrician_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Counselor Review Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Counselor Assessment</h3>
                    
                    <form method="POST" action="{{ route('counselor.approve', $result) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="counselor_notes" :value="__('Assessment Notes *')" />
                            <textarea id="counselor_notes" name="counselor_notes" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                rows="4">{{ old('counselor_notes') }}</textarea>
                            <x-input-error :messages="$errors->get('counselor_notes')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="recommendation" :value="__('Recommendation')" />
                            <select id="recommendation" name="recommendation" 
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select recommendation</option>
                                <option value="Recommended">Recommended for Admission</option>
                                <option value="Needs Intervention">Needs Intervention</option>
                                <option value="For Review">For Further Review</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('counselor.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Approve & Sign') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('counselor.return', $result) }}" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        @csrf
                        <p class="text-sm text-gray-500 mb-2">Or return to psychometrician for revision:</p>
                        <div class="flex gap-2">
                            <input type="text" name="rejection_reason" placeholder="Reason for return" required
                                class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Return
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
