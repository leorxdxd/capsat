<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('Interpretation Tables (Norms)') }}
            </h2>
            <a href="{{ route('norms.create') }}" class="bg-sisc-purple hover:bg-violet-800 text-white font-bold py-2 px-3 sm:px-4 rounded-lg flex items-center text-sm shadow-sm hover:shadow-md transition-all">
                <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="hidden sm:inline">Create New Table</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-4 sm:p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Desktop Table --}}
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sisc-purple text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Exam</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($normTables as $table)
                                    <tr class="hover:bg-purple-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $table->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $table->exam->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-600">{{ Str::limit($table->description, 50) }}</span>
                                            <div class="text-xs font-bold text-sisc-purple mt-1 bg-purple-50 inline-block px-2 py-0.5 rounded-full border border-purple-100">
                                                {{ $table->norm_ranges_count }} ranges
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                                            <a href="{{ route('norms.show', $table) }}" class="text-sisc-purple hover:text-violet-800 font-bold hover:underline">
                                                Manage Ranges
                                            </a>
                                            <a href="{{ route('norms.edit', $table) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                Edit
                                            </a>
                                            <form action="{{ route('norms.destroy', $table) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this table? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p>No interpretation tables found.</p>
                                                <a href="{{ route('norms.create') }}" class="mt-2 text-sisc-purple font-bold hover:underline">Create your first table</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden space-y-4">
                        @forelse($normTables as $table)
                            <div class="bg-white border border-gray-100 rounded-lg p-5 hover:shadow-md transition-shadow">
                                <div class="mb-3 border-b border-gray-50 pb-3">
                                    <p class="font-bold text-gray-900 text-base">{{ $table->name }}</p>
                                    <p class="text-xs font-semibold text-sisc-purple mt-0.5">{{ $table->exam->title }}</p>
                                </div>
                                @if($table->description)
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($table->description, 80) }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between text-sm pt-2">
                                     <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $table->norm_ranges_count }} ranges</span>
                                     <div class="flex items-center gap-4 font-medium">
                                        <a href="{{ route('norms.show', $table) }}" class="text-sisc-purple hover:underline font-bold">Manage</a>
                                        <a href="{{ route('norms.edit', $table) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('norms.destroy', $table) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                     </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                                <p>No interpretation tables found.</p>
                                <a href="{{ route('norms.create') }}" class="mt-2 text-sisc-purple font-bold hover:underline">Create New Table</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

