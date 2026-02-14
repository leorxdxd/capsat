<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Review Result') }}
            </h2>
            <a href="{{ route('results.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Results
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

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
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Status & Actions</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Current Status</p>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $result->status === 'official' ? 'bg-green-100 text-green-800' : 
                               ($result->status === 'returned' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                        </span>
                    </div>

                    <div class="flex gap-2">
                        @if($result->status === 'draft' || $result->status === 'returned')
                            <form method="POST" action="{{ route('results.sendToCounselor', $result) }}">
                                @csrf
                                <x-primary-button>
                                    {{ __('Send to Counselor') }}
                                </x-primary-button>
                            </form>
                        @endif

                        @if($result->status === 'counselor_signed')
                            <form method="POST" action="{{ route('results.finalSign', $result) }}">
                                @csrf
                                <x-primary-button>
                                    {{ __('Final Sign & Approve') }}
                                </x-primary-button>
                            </form>
                        @endif

                        @if($result->canBePrinted())
                            <a href="{{ route('results.pdf', $result) }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                                {{ __('View PDF') }}
                            </a>
                            <a href="{{ route('results.pdf.download', $result) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Download PDF') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Signatures</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Psychometrician</p>
                            @if($result->hasPsychometricianSignature())
                                @php $sig = $result->signatures->where('role', 'psychometrician')->first(); @endphp
                                <p class="font-medium">{{ $sig->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $sig->signed_at->format('M d, Y h:i A') }}</p>
                            @else
                                <p class="text-gray-400 italic">Pending signature</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Counselor</p>
                            @if($result->hasCounselorSignature())
                                @php $sig = $result->signatures->where('role', 'counselor')->first(); @endphp
                                <p class="font-medium">{{ $sig->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $sig->signed_at->format('M d, Y h:i A') }}</p>
                            @else
                                <p class="text-gray-400 italic">Pending signature</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
