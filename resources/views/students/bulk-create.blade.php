<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">Bulk Student Registration</h2>
            <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-sisc-purple flex items-center text-sm font-bold transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="bulkRegistration()">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- STEP 1: INPUT --}}
            <div x-show="step === 'input'" x-transition>

                <!-- Instructions -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-5 mb-6 shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-sisc-purple text-white rounded-full p-1 mt-0.5 mr-3 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-purple-900 font-bold text-lg">How to Bulk Register Students</p>
                            <p class="text-purple-800 text-sm mt-1">You can import students by <strong>uploading a CSV file</strong> or <strong>pasting data from Google Sheets</strong>. Required columns: <code class="bg-white px-1.5 py-0.5 rounded border border-purple-200 font-mono text-purple-700 font-bold text-xs">First Name</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-purple-200 font-mono text-purple-700 font-bold text-xs">Last Name</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-purple-200 font-mono text-purple-700 font-bold text-xs">Email</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-purple-200 font-mono text-purple-700 font-bold text-xs">Grade Level</code>.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Option 1: Paste from Google Sheets -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Paste from Google Sheets
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 mb-3 font-medium">Copy rows from your Google Sheet (with headers) and paste below.</p>
                            <textarea x-ref="pasteArea" x-model="pasteData" rows="10"
                                      placeholder="First Name&#9;Last Name&#9;Email&#9;Grade Level&#9;Gender&#9;Middle Name&#10;Juan&#9;Dela Cruz&#9;juan@email.com&#9;Grade 7&#9;Male&#9;Santos&#10;Maria&#9;Reyes&#9;maria@email.com&#9;Grade 7&#9;Female&#9;"
                                      class="w-full border-gray-300 rounded-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono text-xs leading-relaxed bg-gray-50"></textarea>
                            <button type="button" @click="parsePaste()" :disabled="!pasteData.trim()"
                                    class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-3 rounded-lg font-bold transition-all flex items-center justify-center shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                Check & Preview Data
                            </button>
                        </div>
                    </div>

                    <!-- Option 2: Upload CSV -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-sisc-purple to-violet-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Upload CSV File
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 mb-3 font-medium">Upload a .csv file with headers.</p>

                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-sisc-purple hover:bg-purple-50 transition-all group"
                                 @click="$refs.csvInput.click()"
                                 @dragover.prevent="dragOver = true" @dragleave="dragOver = false"
                                 @drop.prevent="dragOver = false; handleDrop($event)"
                                 :class="dragOver ? 'border-sisc-purple bg-purple-50' : ''">
                                <div class="bg-gray-100 group-hover:bg-white rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center transition-colors">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-sisc-purple transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700 group-hover:text-sisc-purple transition-colors">Click to browse or drag & drop</p>
                                <p class="text-xs text-gray-500 mt-1">.csv files only</p>
                                <p class="text-sm text-emerald-600 mt-2 font-bold bg-emerald-50 inline-block px-3 py-1 rounded-lg" x-show="csvFileName" x-text="csvFileName"></p>
                            </div>
                            <input type="file" accept=".csv" x-ref="csvInput" class="hidden" @change="handleCsvUpload($event)">

                            <button type="button" @click="parseCsv()" :disabled="!csvContent"
                                    class="mt-4 w-full bg-sisc-purple hover:bg-violet-900 disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-3 rounded-lg font-bold transition-all flex items-center justify-center shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                Check & Preview Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Manual Entry Fallback -->
                <div class="text-center mt-6">
                    <button type="button" @click="addManualRows()" class="text-sm text-gray-500 hover:text-sisc-purple font-bold transition-colors flex items-center justify-center gap-1 mx-auto">
                        <span>Or enter manually instead</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                </div>
            </div>

            {{-- STEP 2: PREVIEW & VALIDATE --}}
            <div x-show="step === 'preview'" x-transition>

                <!-- Validation Summary -->
                <div class="rounded-lg p-5 mb-6 shadow-sm border" :class="allValid ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200'">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center">
                            <template x-if="allValid">
                                <div class="bg-emerald-100 rounded-full p-1 mr-3">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </template>
                            <template x-if="!allValid">
                                <div class="bg-amber-100 rounded-full p-1 mr-3">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            </template>
                            <div>
                                <p class="font-bold text-lg" :class="allValid ? 'text-emerald-900' : 'text-amber-900'">
                                    <span x-text="validCount"></span> valid, <span x-text="errorCount"></span> with errors — <span x-text="rows.length"></span> total
                                </p>
                                <p class="text-sm mt-0.5 font-medium" :class="allValid ? 'text-emerald-700' : 'text-amber-700'" x-show="!allValid">
                                    Fix the errors below or remove invalid rows, then click "Re-Check" to validate again.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="step = 'input'; rows = []; parseError = ''"
                                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">
                                ← Start Over
                            </button>
                            <button type="button" @click="validateAll()"
                                    class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-bold transition-colors flex items-center shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Re-Check
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Parse Error -->
                <template x-if="parseError">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 relative">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-red-800 font-bold" x-text="parseError"></p>
                        </div>
                    </div>
                </template>

                <!-- Editable Table -->
                <form method="POST" action="{{ route('students.bulk.store') }}">
                    @csrf

                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Student Preview — <span x-text="rows.length"></span> students
                            </h3>
                            <button type="button" @click="addRow()" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg text-sm font-bold transition-colors flex items-center backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add Row
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-10">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">First Name <span class="text-red-500">*</span></th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Last Name <span class="text-red-500">*</span></th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email <span class="text-red-500">*</span></th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Grade <span class="text-red-500">*</span></th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Middle Name</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-10"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="(row, index) in rows" :key="row.id">
                                        <tr :class="row.errors.length > 0 ? 'bg-red-50/50' : (row.validated ? 'bg-green-50/30' : '')" class="hover:bg-gray-50 transition-colors">
                                            <!-- Status Icon -->
                                            <td class="px-4 py-3">
                                                <template x-if="row.validated && row.errors.length === 0">
                                                    <div class="bg-emerald-100 text-emerald-600 rounded-full w-6 h-6 flex items-center justify-center">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </template>
                                                <template x-if="row.errors.length > 0">
                                                    <div x-data="{ showErr: false }" class="relative">
                                                        <div @mouseenter="showErr = true" @mouseleave="showErr = false" class="bg-red-100 text-red-600 rounded-full w-6 h-6 flex items-center justify-center cursor-help">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                        <div x-show="showErr" x-transition class="absolute z-20 left-8 top-0 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 shadow-xl whitespace-nowrap">
                                                            <template x-for="err in row.errors"><p class="font-medium" x-text="'• ' + err"></p></template>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template x-if="!row.validated && row.errors.length === 0">
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-200"></div>
                                                </template>
                                            </td>
                                            <!-- Row Number -->
                                            <td class="px-4 py-3 text-gray-400 font-mono text-xs font-bold" x-text="index + 1"></td>
                                            <!-- First Name -->
                                            <td class="px-4 py-3">
                                                <input type="text" :name="`students[${index}][first_name]`" x-model="row.first_name"
                                                       class="w-full text-sm border-gray-300 rounded-none focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow"
                                                       :class="row.errors.includes('First name is required') ? 'border-red-300 bg-red-50 focus:ring-red-200' : ''">
                                            </td>
                                            <!-- Last Name -->
                                            <td class="px-4 py-3">
                                                <input type="text" :name="`students[${index}][last_name]`" x-model="row.last_name"
                                                       class="w-full text-sm border-gray-300 rounded-none focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow"
                                                       :class="row.errors.includes('Last name is required') ? 'border-red-300 bg-red-50 focus:ring-red-200' : ''">
                                            </td>
                                            <!-- Email -->
                                            <td class="px-4 py-3">
                                                <input type="email" :name="`students[${index}][email]`" x-model="row.email"
                                                       class="w-full text-sm border-gray-300 rounded-none focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow"
                                                       :class="row.errors.some(e => e.includes('Email') || e.includes('email')) ? 'border-red-300 bg-red-50 focus:ring-red-200' : ''">
                                            </td>
                                            <!-- Grade Level -->
                                            <td class="px-4 py-3">
                                                <select :name="`students[${index}][current_grade_level]`" x-model="row.current_grade_level"
                                                        class="w-full text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow"
                                                        :class="row.errors.includes('Grade level is required') ? 'border-red-300 bg-red-50 focus:ring-red-200' : ''">
                                                    <option value="">—</option>
                                                    <option value="Kinder">Kinder</option>
                                                    <option value="Grade 1">Grade 1</option><option value="Grade 2">Grade 2</option>
                                                    <option value="Grade 3">Grade 3</option><option value="Grade 4">Grade 4</option>
                                                    <option value="Grade 5">Grade 5</option><option value="Grade 6">Grade 6</option>
                                                    <option value="Grade 7">Grade 7</option><option value="Grade 8">Grade 8</option>
                                                    <option value="Grade 9">Grade 9</option><option value="Grade 10">Grade 10</option>
                                                    <option value="Grade 11">Grade 11</option><option value="Grade 12">Grade 12</option>
                                                </select>
                                            </td>
                                            <!-- Gender -->
                                            <td class="px-4 py-3">
                                                <select :name="`students[${index}][gender]`" x-model="row.gender"
                                                        class="w-full text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow">
                                                    <option value="">—</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </td>
                                            <!-- Middle Name -->
                                            <td class="px-4 py-3">
                                                <input type="text" :name="`students[${index}][middle_name]`" x-model="row.middle_name"
                                                       class="w-full text-sm border-gray-300 rounded-none focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple py-1.5 px-3 transition-shadow">
                                            </td>
                                            <!-- Remove -->
                                            <td class="px-4 py-3 text-center">
                                                <button type="button" @click="removeRow(row.id)" x-show="rows.length > 1"
                                                        class="text-gray-400 hover:text-red-500 p-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6">
                        <p class="text-sm text-gray-500 font-medium">
                            <span class="font-bold text-emerald-600" x-text="validCount"></span> valid /
                            <span class="font-bold" :class="errorCount > 0 ? 'text-red-600' : 'text-gray-600'" x-text="errorCount"></span> errors /
                            <span x-text="rows.length"></span> total
                        </p>
                        <button type="submit" :disabled="!allValid || rows.length === 0"
                                class="bg-sisc-purple hover:bg-violet-900 disabled:opacity-50 disabled:cursor-not-allowed text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Register <span x-text="validCount"></span> Students
                        </button>
                    </div>
                </form>
            </div>

            @if ($errors->has('duplicate_emails'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-red-800 font-bold">{{ $errors->first('duplicate_emails') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function bulkRegistration() {
            let nextId = 1;
            const validGrades = ['Kinder','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Grade 7','Grade 8','Grade 9','Grade 10','Grade 11','Grade 12'];

            return {
                step: 'input',
                pasteData: '',
                csvContent: '',
                csvFileName: '',
                dragOver: false,
                parseError: '',
                rows: [],

                get validCount() { return this.rows.filter(r => r.validated && r.errors.length === 0).length; },
                get errorCount() { return this.rows.filter(r => r.errors.length > 0).length; },
                get allValid() { return this.rows.length > 0 && this.rows.every(r => r.validated && r.errors.length === 0); },

                makeRow(data = {}) {
                    return {
                        id: nextId++,
                        first_name: data.first_name || '',
                        last_name: data.last_name || '',
                        email: data.email || '',
                        current_grade_level: data.current_grade_level || '',
                        gender: data.gender || '',
                        middle_name: data.middle_name || '',
                        errors: [],
                        validated: false
                    };
                },

                addRow() { this.rows.push(this.makeRow()); },
                removeRow(id) { this.rows = this.rows.filter(r => r.id !== id); },

                addManualRows() {
                    this.rows = [];
                    for (let i = 0; i < 5; i++) this.rows.push(this.makeRow());
                    this.step = 'preview';
                },

                // Map column header text to our field names
                mapHeader(h) {
                    h = h.toLowerCase().trim().replace(/[^a-z0-9 _]/g, '');
                    if (['first name', 'first_name', 'firstname', 'given name'].includes(h)) return 'first_name';
                    if (['last name', 'last_name', 'lastname', 'surname', 'family name'].includes(h)) return 'last_name';
                    if (['middle name', 'middle_name', 'middlename'].includes(h)) return 'middle_name';
                    if (['email', 'email address', 'e-mail'].includes(h)) return 'email';
                    if (['grade', 'grade level', 'grade_level', 'gradelevel', 'level'].includes(h)) return 'current_grade_level';
                    if (['gender', 'sex'].includes(h)) return 'gender';
                    return null;
                },

                normalizeGrade(val) {
                    if (!val) return '';
                    val = val.trim();
                    // Try direct match
                    let match = validGrades.find(g => g.toLowerCase() === val.toLowerCase());
                    if (match) return match;
                    // Try "7" → "Grade 7"
                    let num = parseInt(val);
                    if (!isNaN(num) && num >= 1 && num <= 12) return 'Grade ' + num;
                    if (val.toLowerCase().startsWith('k')) return 'Kinder';
                    return val;
                },

                normalizeGender(val) {
                    if (!val) return '';
                    val = val.trim().toLowerCase();
                    if (val === 'm' || val === 'male') return 'Male';
                    if (val === 'f' || val === 'female') return 'Female';
                    return '';
                },

                parsePaste() {
                    this.parseError = '';
                    const lines = this.pasteData.trim().split('\n').filter(l => l.trim());
                    if (lines.length < 2) {
                        this.parseError = 'Need at least a header row and one data row.';
                        return;
                    }

                    // Detect delimiter (tab or comma)
                    const delimiter = lines[0].includes('\t') ? '\t' : ',';
                    const headers = lines[0].split(delimiter).map(h => this.mapHeader(h));

                    if (!headers.includes('first_name') || !headers.includes('last_name') || !headers.includes('email')) {
                        this.parseError = 'Could not find required columns. Make sure headers include: First Name, Last Name, Email, Grade Level';
                        return;
                    }

                    this.rows = [];
                    for (let i = 1; i < lines.length; i++) {
                        const cols = lines[i].split(delimiter);
                        const data = {};
                        headers.forEach((field, idx) => {
                            if (field && cols[idx]) data[field] = cols[idx].trim();
                        });
                        data.current_grade_level = this.normalizeGrade(data.current_grade_level);
                        data.gender = this.normalizeGender(data.gender);
                        this.rows.push(this.makeRow(data));
                    }

                    this.validateAll();
                    this.step = 'preview';
                },

                handleCsvUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    this.csvFileName = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.csvContent = e.target.result; };
                    reader.readAsText(file);
                },

                handleDrop(event) {
                    const file = event.dataTransfer.files[0];
                    if (!file || !file.name.endsWith('.csv')) return;
                    this.csvFileName = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.csvContent = e.target.result; };
                    reader.readAsText(file);
                },

                parseCsv() {
                    this.parseError = '';
                    if (!this.csvContent) return;

                    // Simple CSV parser (handles quoted fields)
                    const parseCSVLine = (line) => {
                        const result = [];
                        let current = '';
                        let inQuotes = false;
                        for (let i = 0; i < line.length; i++) {
                            const c = line[i];
                            if (c === '"') { inQuotes = !inQuotes; }
                            else if (c === ',' && !inQuotes) { result.push(current.trim()); current = ''; }
                            else { current += c; }
                        }
                        result.push(current.trim());
                        return result;
                    };

                    const lines = this.csvContent.trim().split('\n').filter(l => l.trim());
                    if (lines.length < 2) {
                        this.parseError = 'CSV file needs at least a header row and one data row.';
                        return;
                    }

                    const headers = parseCSVLine(lines[0]).map(h => this.mapHeader(h));

                    if (!headers.includes('first_name') || !headers.includes('last_name') || !headers.includes('email')) {
                        this.parseError = 'CSV missing required columns. Make sure headers include: First Name, Last Name, Email, Grade Level';
                        return;
                    }

                    this.rows = [];
                    for (let i = 1; i < lines.length; i++) {
                        const cols = parseCSVLine(lines[i]);
                        const data = {};
                        headers.forEach((field, idx) => {
                            if (field && cols[idx]) data[field] = cols[idx].trim();
                        });
                        data.current_grade_level = this.normalizeGrade(data.current_grade_level);
                        data.gender = this.normalizeGender(data.gender);
                        this.rows.push(this.makeRow(data));
                    }

                    this.validateAll();
                    this.step = 'preview';
                },

                validateRow(row) {
                    row.errors = [];
                    if (!row.first_name.trim()) row.errors.push('First name is required');
                    if (!row.last_name.trim()) row.errors.push('Last name is required');
                    if (!row.email.trim()) row.errors.push('Email is required');
                    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(row.email)) row.errors.push('Email format is invalid');
                    if (!row.current_grade_level) row.errors.push('Grade level is required');
                    else if (!validGrades.includes(row.current_grade_level)) row.errors.push('Invalid grade level: ' + row.current_grade_level);

                    // Check duplicate emails within the batch
                    const dupes = this.rows.filter(r => r.id !== row.id && r.email.trim().toLowerCase() === row.email.trim().toLowerCase());
                    if (row.email.trim() && dupes.length > 0) row.errors.push('Duplicate email in batch');

                    row.validated = true;
                },

                validateAll() {
                    this.rows.forEach(r => this.validateRow(r));
                }
            };
        }
    </script>
</x-app-layout>

