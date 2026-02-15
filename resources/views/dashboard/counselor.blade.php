<!-- Counselor Dashboard -->
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-green-100">Guidance Counselor Dashboard</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pending Reviews</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\ExamResult::where('status', 'for_counselor')->count() }}</p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Approved</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\ExamResult::where('status', 'counselor_signed')->count() }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Reviewed</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\ResultSignature::where('role', 'counselor')->count() }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pending Reviews -->
        <a href="{{ route('counselor.reviews') }}" class="group bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all hover:-translate-y-1 text-white">
            <div class="flex items-center mb-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold">Review Results</h3>
                    <p class="text-green-100 text-sm">{{ \App\Models\ExamResult::where('status', 'for_counselor')->count() }} pending</p>
                </div>
            </div>
            <p class="text-green-100 mb-4">Review student exam results and provide recommendations</p>
            <div class="flex items-center text-white font-medium">
                <span>Go to Reviews</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
        </a>

        <!-- My Reviews -->
        <a href="#" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">My Reviews</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">View history</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">View all results you've reviewed and approved</p>
            <div class="flex items-center text-blue-600 dark:text-blue-400 font-medium">
                <span>View History</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
        </a>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Activity</h3>
            <a href="{{ route('counselor.reviews') }}" class="text-sm text-green-600 dark:text-green-400 hover:underline">View All</a>
        </div>
        <div class="space-y-3">
            @forelse(\App\Models\ExamResult::with(['student', 'exam'])->where('status', 'for_counselor')->latest()->take(5)->get() as $result)
                <a href="{{ route('counselor.show', $result) }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-green-100 dark:bg-green-900 rounded-full p-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $result->student->first_name }} {{ $result->student->last_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $result->exam->title }} • Score: {{ $result->raw_score }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                Pending Review
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $result->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">No pending reviews at the moment</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">New results will appear here when ready for review</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
