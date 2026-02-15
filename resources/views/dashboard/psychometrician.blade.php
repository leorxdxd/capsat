<!-- Psychometrician Dashboard -->
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-blue-100">Psychometrician Dashboard</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Exams</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Exam::count() }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Norm Tables</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\NormTable::count() }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pending Review</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\ExamResult::whereIn('status', ['draft', 'returned'])->count() }}</p>
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
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Official Results</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\ExamResult::where('status', 'official')->count() }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Exam Management -->
        <a href="{{ route('exams.index') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold text-gray-900 dark:text-white">Exam Management</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Create and manage entrance examinations</p>
            <div class="flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                <span>Manage Exams</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Norm Tables -->
        <a href="{{ route('norms.index') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold text-gray-900 dark:text-white">Interpretation Tables</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Define norm ranges and performance levels</p>
            <div class="flex items-center text-purple-600 dark:text-purple-400 text-sm font-medium">
                <span>Manage Norms</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Results Review -->
        <a href="{{ route('results.index') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold text-gray-900 dark:text-white">Results Review</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Review and process exam results</p>
            <div class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                <span>Review Results</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Create New Exam -->
        <a href="{{ route('exams.create') }}" class="group bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1 text-white">
            <div class="flex items-center mb-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold">Create New Exam</h3>
            </div>
            <p class="text-blue-100 text-sm mb-3">Set up a new entrance examination</p>
            <div class="flex items-center text-white text-sm font-medium">
                <span>Get Started</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Create Norm Table -->
        <a href="{{ route('norms.create') }}" class="group bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1 text-white">
            <div class="flex items-center mb-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold">Create Norm Table</h3>
            </div>
            <p class="text-purple-100 text-sm mb-3">Define new interpretation criteria</p>
            <div class="flex items-center text-white text-sm font-medium">
                <span>Get Started</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Statistics -->
        <a href="#" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012-2v2a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-bold text-gray-900 dark:text-white">Statistics</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">View exam performance analytics</p>
            <div class="flex items-center text-orange-600 dark:text-orange-400 text-sm font-medium">
                <span>View Stats</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Results</h3>
        <div class="space-y-3">
            @forelse(\App\Models\ExamResult::with(['student', 'exam'])->latest()->take(5)->get() as $result)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $result->student->first_name }} {{ $result->student->last_name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $result->exam->title }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $result->status === 'official' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                               ($result->status === 'returned' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300') }}">
                            {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No results yet</p>
            @endforelse
        </div>
    </div>
</div>
