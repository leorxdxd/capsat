<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Exam Retake Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg relative mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="block sm:inline font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($requests->isEmpty())
                        <div class="text-center py-12 from-gray-50 to-white bg-gradient-to-b rounded-lg border border-gray-100">
                            <svg class="w-12 h-12 text-gray-300 mb-3 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-gray-500 font-medium">No pending retake requests.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-sisc-purple text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Student</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Exam</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Requested At</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Reason</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($requests as $request)
                                        <tr class="hover:bg-purple-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $request->user->student->first_name }} {{ $request->user->student->last_name }}</div>
                                                <div class="text-xs text-gray-500">{{ $request->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600 font-medium">{{ $request->exam->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $request->retake_requested_at->format('M d, Y h:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500 max-w-xs truncate italic">"{{ $request->retake_reason ?? 'No reason provided' }}"</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form method="POST" action="{{ route('results.retakes.approve', $request) }}" onsubmit="return confirm('Approve retake? This will archive the current attempt and allow the student to start new.');">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-900 font-bold bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 hover:bg-emerald-100 transition-colors">Approve Retake</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

