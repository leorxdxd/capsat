<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            Import Norm Data: {{ $norm->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8 text-gray-900">
                    
                    {{-- Instructions --}}
                    <div class="mb-8 bg-blue-50 border border-blue-100 rounded-lg p-6">
                        <h3 class="font-bold text-blue-800 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Instructions
                        </h3>
                        <p class="text-sm text-blue-800 mb-4 ">
                            You can import norm entries using a CSV/Excel file or by pasting data directly. 
                            The data <strong>must</strong> have the following 8 columns in order:
                        </p>
                        <ol class="list-decimal list-inside text-sm text-blue-900 space-y-1 ml-2 font-mono bg-white p-4 rounded-lg border border-blue-200">
                            <li>Age (Years)</li>
                            <li>Month Start (0-11)</li>
                            <li>Month End (0-11)</li>
                            <li>Raw Score (RS)</li>
                            <li>SAI</li>
                            <li>Percentile (%TILE)</li>
                            <li>Stanine (STA)</li>
                            <li>Description (DES)</li>
                        </ol>
                        <p class="text-xs text-blue-600 mt-3 ml-1 font-medium">
                            <em>Example:</em> 14, 0, 2, 21, 53, 1, 1, Low
                        </p>
                    </div>

                    <form method="POST" action="{{ route('norms.processImport', $norm) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            {{-- Option 1: File Upload --}}
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Option 1: Upload CSV
                                </h3>
                                <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-300 border-dashed rounded-lg hover:border-sisc-purple transition-colors bg-gray-50 hover:bg-purple-50 group">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-sisc-purple transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="import_file" class="relative cursor-pointer rounded-md font-bold text-sisc-purple hover:text-violet-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sisc-purple">
                                                <span>Upload a file</span>
                                                <input id="import_file" name="import_file" type="file" class="sr-only" accept=".csv,.txt">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">CSV, TXT up to 2MB</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Option 2: Paste Data --}}
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Option 2: Paste Data
                                </h3>
                                <textarea name="paste_data" rows="10" 
                                    class="shadow-sm focus:ring-sisc-purple focus:border-sisc-purple block w-full sm:text-sm border-gray-300 rounded-none font-mono text-xs leading-relaxed"
                                    placeholder="14	0	2	21	53	1	1	Low
14	0	2	22	56	1	1	Low
..."></textarea>
                                <p class="text-xs text-gray-500 mt-2 font-medium">Paste directly from Excel (tab-separated) or CSV.</p>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                            <a href="{{ route('norms.show', $norm) }}" class="bg-white py-2.5 px-5 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sisc-purple transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-sisc-purple py-2.5 px-6 border border-transparent rounded-lg shadow-md text-sm font-bold text-white hover:bg-violet-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sisc-purple transition-all hover:shadow-lg hover:-translate-y-0.5">
                                Import Entries
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

