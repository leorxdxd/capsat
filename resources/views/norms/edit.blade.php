<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Edit Interpretation Table') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('norms.update', $norm) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <x-input-label for="exam_id" :value="__('Exam *')" class="text-gray-700 font-bold" />
                            <select id="exam_id" name="exam_id" required
                                class="block mt-2 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-lg shadow-sm transition-colors">
                                <option value="">Select an exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id', $norm->exam_id) == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->title }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('exam_id')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Table Name *')" class="text-gray-700 font-bold" />
                            <x-text-input id="name" class="block mt-2 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-none shadow-sm" type="text" name="name" :value="old('name', $norm->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="description" :value="__('Description')" class="text-gray-700 font-bold" />
                            <textarea id="description" name="description"
                                class="block mt-2 w-full border-gray-300 focus:border-sisc-purple focus:ring-sisc-purple rounded-none shadow-sm transition-colors"
                                rows="3">{{ old('description', $norm->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('norms.show', $norm) }}" class="text-gray-500 hover:text-gray-900 font-medium transition-colors">Cancel</a>
                            <x-primary-button class="bg-sisc-purple hover:bg-violet-800 focus:ring-violet-500 rounded-lg px-6 py-3">
                                {{ __('Update Table') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

