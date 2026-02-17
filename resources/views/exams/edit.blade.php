<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('Edit Exam') }}
            </h2>
            <a href="{{ route('exams.show', $exam) }}" class="text-gray-500 hover:text-sisc-purple flex items-center text-sm font-bold transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Exam Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit: <span class="text-purple-100 ml-1">{{ $exam->title }}</span>
                    </h3>
                </div>

                <form method="POST" action="{{ route('exams.update', $exam) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Exam Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $exam->title) }}" required
                               class="w-full border-gray-300 rounded-none shadow-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-all">
                        @error('title') <p class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full border-gray-300 rounded-none shadow-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-all">{{ old('description', $exam->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="target_grade_level" class="block text-sm font-bold text-gray-700 mb-2">Target Grade Level</label>
                            <select id="target_grade_level" name="target_grade_level"
                                    class="w-full border-gray-300 rounded-none shadow-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-all">
                                <option value="">All Grades</option>
                                @foreach(['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                    <option value="{{ $grade }}" {{ old('target_grade_level', $exam->target_grade_level) === $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="time_limit" class="block text-sm font-bold text-gray-700 mb-2">Time Limit (minutes)</label>
                            <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit', $exam->time_limit) }}" min="1"
                                   class="w-full border-gray-300 rounded-none shadow-sm focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-all"
                                   placeholder="Leave empty for unlimited">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 py-4 px-4 bg-purple-50 border border-purple-100 rounded-lg">
                        <input type="checkbox" id="active" name="active" value="1" {{ old('active', $exam->active) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-gray-300 text-sisc-purple focus:ring-sisc-purple transition-colors">
                        <label for="active" class="text-sm font-bold text-purple-900">
                            Exam is active and available for use
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-6">
                        <button type="button" onclick="if(confirm('Are you sure you want to delete this exam? All sections and questions will be permanently removed.')) document.getElementById('delete-form').submit();" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center px-3 py-2 rounded-lg hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Exam
                        </button>

                        <div class="flex gap-3">
                            <a href="{{ route('exams.show', $exam) }}" class="px-5 py-2.5 text-gray-600 hover:text-gray-800 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-6 py-2.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
                <form id="delete-form" method="POST" action="{{ route('exams.destroy', $exam) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

