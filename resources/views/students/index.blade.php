<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('Student Management') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('students.bulk.create') }}" class="bg-white border border-sisc-gold text-sisc-gold hover:bg-amber-50 px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg transition-all flex items-center font-bold text-sm shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path></svg>
                    <span class="hidden sm:inline">Bulk Register</span>
                </a>
                <a href="{{ route('students.create') }}" class="bg-sisc-purple hover:bg-violet-900 text-white px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg transition-all flex items-center font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span class="hidden sm:inline">Register Student</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search & Filter Bar -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6 mb-8">
                <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                    <div class="sm:col-span-2 md:col-span-2">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, app #, or LRN..."
                                   class="w-full pl-10 border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple text-sm">
                        </div>
                    </div>
                    <div>
                        <select name="grade_level" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple text-sm">
                            <option value="">All Grades</option>
                            @foreach(['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                <option value="{{ $grade }}" {{ request('grade_level') === $grade ? 'selected' : '' }}>{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-sisc-purple hover:bg-violet-900 text-white rounded-lg px-4 py-2 font-bold transition-all shadow-md hover:shadow-lg text-sm">
                            Search
                        </button>
                        @if(request()->hasAny(['search', 'grade_level', 'gender']))
                            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors border border-gray-200" title="Clear filters">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Students Count -->
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500 font-bold">
                    Showing <span class="text-sisc-purple">{{ $students->total() }}</span> student{{ $students->total() !== 1 ? 's' : '' }}
                </p>
            </div>

            @if($students->isEmpty())
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
                    <div class="bg-purple-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-sisc-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Students Found</h3>
                    <p class="text-gray-500 mb-6">Register your first student to get started.</p>
                    <a href="{{ route('students.create') }}" class="inline-flex items-center bg-sisc-purple hover:bg-violet-900 text-white px-6 py-3 rounded-lg font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Register First Student
                    </a>
                </div>
            @else
                {{-- Desktop Table --}}
                <div class="hidden md:block bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Application #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Grade Level</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Age</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Gender</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach($students as $student)
                                <tr class="hover:bg-purple-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-sisc-purple to-violet-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white font-bold text-xs">{{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-bold text-gray-900 group-hover:text-sisc-purple transition-colors">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }}</p>
                                                <p class="text-xs text-gray-500">{{ $student->user->email ?? 'No email' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-mono font-bold bg-gray-100 text-gray-600 rounded-lg border border-gray-200">
                                            {{ $student->application_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-700">{{ $student->current_grade_level ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-700">{{ $student->age }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg border {{ $student->gender === 'Male' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-pink-50 text-pink-700 border-pink-100' }}">
                                            {{ $student->gender ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $student->contact_number ?? '—' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('students.show', $student) }}" class="text-gray-400 hover:text-sisc-purple p-2 rounded-lg hover:bg-purple-50 transition-colors" title="View Profile">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('students.edit', $student) }}" class="text-gray-400 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden space-y-3">
                    @foreach($students as $student)
                        <a href="{{ route('students.show', $student) }}" class="block bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:border-sisc-purple transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-sisc-purple to-violet-600 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $student->last_name }}, {{ $student->first_name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $student->user->email ?? 'No email' }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="px-2 py-0.5 font-mono font-bold bg-gray-100 text-gray-600 rounded">{{ $student->application_number ?? 'N/A' }}</span>
                                <span class="text-gray-500">{{ $student->current_grade_level ?? 'N/A' }}</span>
                                <span class="text-gray-300">·</span>
                                <span class="text-gray-500">Age {{ $student->age }}</span>
                                <span class="px-2 py-0.5 font-bold rounded-lg {{ $student->gender === 'Male' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">{{ $student->gender ?? 'N/A' }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

