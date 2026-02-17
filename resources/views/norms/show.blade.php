<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                    {{ $norm->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $norm->exam->title }} · Norm Table</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('norms.edit', $norm) }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg text-sm font-bold transition-colors flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </a>
                <a href="{{ route('norms.index') }}" class="text-gray-500 hover:text-sisc-purple flex items-center text-sm font-bold gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    All Tables
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="px-4 sm:px-6">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm font-bold text-red-700 mb-2">Please fix the following errors:</p>
                    <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table Info --}}
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6 mb-8 hover:shadow-md transition-shadow">
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-500 uppercase tracking-widest font-bold mb-1">Exam Title</p>
                        <p class="text-lg font-bold text-gray-900">{{ $norm->exam->title }}</p>
                        @if($norm->description)
                            <p class="text-sm text-gray-600 mt-2 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $norm->description }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-sisc-purple">{{ $norm->normRanges()->count() }}</p>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Entries</p>
                        <p class="text-xs text-sisc-gold font-bold mt-1">{{ $groupedRanges->count() }} Age Groups</p>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════
                 TEST LOOKUP CARD
                 ═══════════════════════════════════ --}}
            <div class="mb-8" x-data="{ open: {{ session('check_success') || session('check_error') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="flex items-center gap-2 text-sm font-bold text-sisc-purple hover:text-violet-800 mb-3 transition-colors bg-purple-50 px-3 py-1.5 rounded-lg border border-purple-100 hover:bg-purple-100">
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    Test Norm Lookup
                </button>
                
                <div x-show="open" x-collapse class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <form action="{{ route('norms.check', $norm) }}" method="POST" class="flex flex-wrap items-end gap-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Age (Years)</label>
                            <input type="number" name="age_years" required placeholder="14" value="{{ old('age_years') }}"
                                   class="w-28 border border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold text-gray-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Months</label>
                            <input type="number" name="age_months" required placeholder="0" value="{{ old('age_months') }}"
                                   class="w-24 border border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold text-gray-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Raw Score</label>
                            <input type="number" name="raw_score" required placeholder="21" value="{{ old('raw_score') }}"
                                   class="w-28 border border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold text-sisc-purple bg-purple-50">
                        </div>
                        <button type="submit" class="bg-sisc-purple hover:bg-violet-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 mb-[1px]">
                            Check Result
                        </button>
                    </form>

                    @if(session('check_success'))
                        <div class="mt-6 p-4 bg-emerald-50 rounded-lg border border-emerald-100 flex items-center gap-4 animate-fade-in-up">
                            <div class="bg-white text-emerald-600 rounded-full p-2 shadow-sm border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-emerald-800 uppercase tracking-wide font-bold mb-2">Test Result Found</p>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                    <div>
                                        <span class="text-xs text-gray-500 font-semibold block">SAI</span>
                                        <span class="font-black text-gray-900 text-xl">{{ session('check_details')->sai }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 font-semibold block">%TILE</span>
                                        <span class="font-black text-gray-900 text-xl">{{ session('check_details')->percentile }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 font-semibold block">Stanine</span>
                                        <span class="font-black text-gray-900 text-xl">{{ session('check_details')->stanine }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 font-semibold block">Description</span>
                                        <span class="font-black text-sisc-purple text-xl">{{ session('check_details')->description }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('check_error'))
                        <div class="mt-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg flex items-center gap-2 border border-red-100 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('check_error') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- ═══════════════════════════════════
                 ADD ENTRIES FORM
                 ═══════════════════════════════════ --}}
            {{-- ═══════════════════════════════════
                 ADD ENTRIES FORM
                 ═══════════════════════════════════ --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-lg p-6 mb-8" x-data="normEntryForm()">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Add Norm Entries
                    </h3>
                    <a href="{{ route('norms.import', $norm) }}" class="text-sisc-purple hover:text-violet-800 text-sm font-bold flex items-center gap-1 transition-colors bg-purple-50 px-3 py-1.5 rounded-lg hover:bg-purple-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import / Paste Data
                    </a>
                </div>

                {{-- Mode Toggle --}}
                <div class="flex gap-2 mb-6 p-1 bg-gray-50 rounded-lg w-fit">
                    <button @click="mode = 'single'" :class="mode === 'single' ? 'bg-white text-sisc-purple shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all">
                        Single Entry
                    </button>
                    <button @click="mode = 'bulk'" :class="mode === 'bulk' ? 'bg-white text-sisc-purple shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all">
                        Bulk (Multiple Rows)
                    </button>
                </div>

                {{-- ── Single Entry Mode ── --}}
                <form x-show="mode === 'single'" method="POST" action="{{ route('norms.addRange', $norm) }}">
                    @csrf
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Age (yrs)</label>
                            <input type="number" name="age_years" min="1" max="99" required placeholder="14" value="{{ old('age_years') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Months From</label>
                            <input type="number" name="age_months_start" min="0" max="11" required placeholder="0" value="{{ old('age_months_start') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Months To</label>
                            <input type="number" name="age_months_end" min="0" max="11" required placeholder="2" value="{{ old('age_months_end') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Raw Score</label>
                            <input type="number" name="raw_score" min="0" required placeholder="21" value="{{ old('raw_score') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold bg-purple-50 text-sisc-purple">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">SAI</label>
                            <input type="number" name="sai" min="0" required placeholder="53" value="{{ old('sai') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">%TILE</label>
                            <input type="number" name="percentile" min="0" max="100" required placeholder="1" value="{{ old('percentile') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Stanine</label>
                            <input type="number" name="stanine" min="1" max="9" required placeholder="1" value="{{ old('stanine') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Description</label>
                            <input type="text" name="description" required placeholder="L - Low" value="{{ old('description') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-sisc-purple hover:bg-violet-800 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-colors shadow-md hover:shadow-lg hover:-translate-y-0.5">
                            Add Entry
                        </button>
                    </div>
                </form>

                {{-- ── Bulk Entry Mode ── --}}
                <form x-show="mode === 'bulk'" method="POST" action="{{ route('norms.addBulk', $norm) }}" x-cloak>
                    @csrf
                    {{-- Age bracket header --}}
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-100 mb-6">
                        <h4 class="text-xs font-bold text-sisc-purple uppercase tracking-wider mb-3">Target Age Group</h4>
                        <div class="grid grid-cols-3 gap-4 max-w-md">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Age (yrs)</label>
                                <input type="number" name="age_years" min="1" max="99" required placeholder="14" x-model="bulkAge"
                                       class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Months From</label>
                                <input type="number" name="age_months_start" min="0" max="11" required placeholder="0" x-model="bulkMonthsStart"
                                       class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Months To</label>
                                <input type="number" name="age_months_end" min="0" max="11" required placeholder="2" x-model="bulkMonthsEnd"
                                       class="w-full border-gray-300 rounded-lg text-sm px-3 py-2 text-center focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple font-bold">
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 font-bold mb-3 uppercase tracking-wider">Norm Entries</p>

                    {{-- Bulk rows --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg mb-4">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase border-b border-gray-200">
                                    <th class="text-left py-3 px-4 w-16">#</th>
                                    <th class="text-left py-3 px-4">RS</th>
                                    <th class="text-left py-3 px-4">SAI</th>
                                    <th class="text-left py-3 px-4">%TILE</th>
                                    <th class="text-left py-3 px-4">STA</th>
                                    <th class="text-left py-3 px-4">Description</th>
                                    <th class="py-3 px-4 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in bulkRows" :key="index">
                                    <tr class="bg-white">
                                        <td class="py-2 px-4 text-gray-400 font-mono text-xs" x-text="index + 1"></td>
                                        <td class="py-2 px-4">
                                            <input type="number" :name="'entries[' + index + '][raw_score]'" min="0" required placeholder="RS" x-model="row.raw_score"
                                                   class="w-20 border-gray-300 rounded-lg text-sm px-2 py-1.5 focus:ring-sisc-purple focus:border-sisc-purple font-bold text-sisc-purple bg-purple-50">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="number" :name="'entries[' + index + '][sai]'" min="0" required placeholder="SAI" x-model="row.sai"
                                                   class="w-20 border-gray-300 rounded-lg text-sm px-2 py-1.5 focus:ring-sisc-purple focus:border-sisc-purple">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="number" :name="'entries[' + index + '][percentile]'" min="0" max="100" required placeholder="%TILE" x-model="row.percentile"
                                                   class="w-20 border-gray-300 rounded-lg text-sm px-2 py-1.5 focus:ring-sisc-purple focus:border-sisc-purple">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="number" :name="'entries[' + index + '][stanine]'" min="1" max="9" required placeholder="STA" x-model="row.stanine"
                                                   class="w-16 border-gray-300 rounded-lg text-sm px-2 py-1.5 focus:ring-sisc-purple focus:border-sisc-purple">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="text" :name="'entries[' + index + '][description]'" required placeholder="L - Low" x-model="row.description"
                                                   class="w-32 border-gray-300 rounded-lg text-sm px-2 py-1.5 focus:ring-sisc-purple focus:border-sisc-purple">
                                        </td>
                                        <td class="py-2 px-4">
                                            <button type="button" @click="removeRow(index)" class="text-red-400 hover:text-red-600 transition-colors p-1 hover:bg-red-50 rounded-lg" x-show="bulkRows.length > 1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <button type="button" @click="addRow()" class="text-sisc-purple hover:text-violet-800 text-sm font-bold flex items-center gap-1 transition-colors px-3 py-1.5 rounded-lg hover:bg-purple-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add Row
                            </button>
                            <span class="text-gray-300">|</span>
                            <button type="button" @click="addRows(5)" class="text-gray-500 hover:text-gray-700 text-xs font-bold transition-colors">
                                + 5 rows
                            </button>
                            <button type="button" @click="addRows(10)" class="text-gray-500 hover:text-gray-700 text-xs font-bold transition-colors">
                                + 10 rows
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400 font-bold" x-text="bulkRows.length + ' row(s)'"></span>
                            <button type="submit" class="bg-sisc-purple hover:bg-violet-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-colors shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                Add All Entries
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ═══════════════════════════════════
                 NORM TABLE DISPLAY (grouped by age bracket)
                 ═══════════════════════════════════ --}}
            
            <div class="mb-6">
                {{ $brackets->links() }}
            </div>

            @forelse($groupedRanges as $bracketKey => $entries)
                @php
                    $first = $entries->first();
                    $bracketLabel = "AGE {$first->age_years}   {$first->age_months_start}-{$first->age_months_end}";
                @endphp
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden mb-8 shadow-sm hover:shadow-md transition-shadow">
                    {{-- Bracket Header --}}
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="bg-sisc-purple text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $bracketLabel }}
                            </span>
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">{{ $entries->count() }} {{ Str::plural('entry', $entries->count()) }}</span>
                        </div>
                        <form action="{{ route('norms.deleteBracket', $norm) }}" method="POST" onsubmit="return confirm('Delete all {{ $entries->count() }} entries for {{ $bracketLabel }}?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="age_years" value="{{ $first->age_years }}">
                            <input type="hidden" name="age_months_start" value="{{ $first->age_months_start }}">
                            <input type="hidden" name="age_months_end" value="{{ $first->age_months_end }}">
                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors hover:bg-red-50 px-2 py-1 rounded-lg">
                                Delete bracket
                            </button>
                        </form>
                    </div>

                    {{-- Data Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">RSCODE</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">RS</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">SAI</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">%TILE</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">STA</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">DES</th>
                                    <th class="px-6 py-3 w-12"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($entries as $entry)
                                    <tr class="hover:bg-purple-50/50 transition-colors group">
                                        <td class="px-6 py-3 font-mono text-gray-400 text-xs">{{ $entry->rscode }}</td>
                                        <td class="px-6 py-3 font-bold text-sisc-purple">{{ $entry->raw_score }}</td>
                                        <td class="px-6 py-3 text-gray-700 font-medium">{{ $entry->sai }}</td>
                                        <td class="px-6 py-3 text-gray-700 font-medium">{{ $entry->percentile }}</td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold
                                                @if($entry->stanine <= 3) bg-red-100 text-red-700
                                                @elseif($entry->stanine <= 6) bg-amber-100 text-amber-700
                                                @else bg-emerald-100 text-emerald-700
                                                @endif">
                                                {{ $entry->stanine }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg
                                                @if(Str::startsWith($entry->description, ['VL', 'L ']))
                                                    bg-red-50 text-red-700 border border-red-100
                                                @elseif(Str::startsWith($entry->description, ['BA', 'BL']))
                                                    bg-orange-50 text-orange-700 border border-orange-100
                                                @elseif(Str::startsWith($entry->description, ['A ']))
                                                    bg-blue-50 text-blue-700 border border-blue-100
                                                @elseif(Str::startsWith($entry->description, ['AA', 'AB']))
                                                    bg-cyan-50 text-cyan-700 border border-cyan-100
                                                @elseif(Str::startsWith($entry->description, ['H ', 'VH', 'S ']))
                                                    bg-emerald-50 text-emerald-700 border border-emerald-100
                                                @else
                                                    bg-gray-100 text-gray-700 border border-gray-200
                                                @endif">
                                                {{ $entry->description }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <form action="{{ route('norms.deleteRange', [$norm, $entry]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this entry?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100 p-1 hover:bg-red-50 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-dashed border-gray-300 rounded-lg p-12 text-center">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                    </div>
                    <p class="text-gray-900 font-bold text-lg mb-1">No norm entries yet</p>
                    <p class="text-gray-500 text-sm">Use the form above to add specific norm entries or import a file.</p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $brackets->links() }}
            </div>
        </div>
    </div>

    <script>
        function normEntryForm() {
            return {
                mode: 'bulk',
                bulkAge: '',
                bulkMonthsStart: '',
                bulkMonthsEnd: '',
                bulkRows: [
                    { raw_score: '', sai: '', percentile: '', stanine: '', description: '' },
                    { raw_score: '', sai: '', percentile: '', stanine: '', description: '' },
                    { raw_score: '', sai: '', percentile: '', stanine: '', description: '' },
                ],

                addRow() {
                    this.bulkRows.push({ raw_score: '', sai: '', percentile: '', stanine: '', description: '' });
                },

                addRows(n) {
                    for (let i = 0; i < n; i++) this.addRow();
                },

                removeRow(index) {
                    if (this.bulkRows.length > 1) {
                        this.bulkRows.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-app-layout>

