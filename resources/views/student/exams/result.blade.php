<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sisc-gold leading-tight">
            {{ __('Exam Completed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-lg shadow-xl overflow-hidden text-center p-12 border border-purple-50">
                <div class="bg-emerald-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                
                <h1 class="text-3xl font-extrabold text-sisc-purple mb-2">Exam Submitted Successfully!</h1>
                <p class="text-lg text-gray-600 mb-8">Thank you for completing the <strong>{{ $result->exam->title }}</strong>.</p>
                
                <div class="max-w-md mx-auto bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                    <h3 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-4">Initial Result</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Raw Score</p>
                            <p class="text-3xl font-extrabold text-sisc-purple">{{ $result->total_score }}</p>
                            <p class="text-xs text-gray-400 mt-1">/ {{ $result->exam->questions->sum('points') }} points</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Date Taken</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $result->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $result->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 italic">
                            Your result has been sent to the Psychometrician for review and processing. You will be notified once the official result is released.
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('student.exams.index') }}" class="px-8 py-3 bg-sisc-purple hover:bg-violet-900 text-white rounded-lg font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        View All Exams
                    </a>
                </div>

                @if(!$attempt->retake_requested_at)
                    <div class="mt-10 border-t border-gray-100 pt-6">
                        <p class="text-sm text-gray-500 mb-4">Feel like you could do better? You can request a retake.</p>
                        <form method="POST" action="{{ route('student.exams.retake', $attempt) }}" onsubmit="return confirm('Are you sure you want to request a retake?');">
                            @csrf
                            <button type="submit" class="text-sisc-purple hover:text-violet-900 font-semibold underline text-sm">
                                Request Retake
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-10 border-t border-gray-100 pt-6">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-amber-50 text-amber-800 border border-amber-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Retake Requested (Pending Approval)
                        </span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

