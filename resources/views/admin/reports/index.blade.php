<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $userStats['total'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="text-green-600">{{ $userStats['active'] }} active</span> &middot; 
                                <span class="text-red-500">{{ $userStats['inactive'] }} inactive</span>
                            </p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Exams -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Exams</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $examStats['total'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="text-green-600">{{ $examStats['active'] }} active</span> &middot;
                                {{ $examStats['total_questions'] }} questions
                            </p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Results -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Exam Results</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $resultStats['total'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="text-green-600">{{ $resultStats['completed'] }} completed</span> &middot;
                                <span class="text-yellow-600">{{ $resultStats['pending'] }} pending</span>
                            </p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012-2v2a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Students -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Students</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $studentStats['total'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $studentStats['with_results'] }} with exam attempts
                            </p>
                        </div>
                        <div class="bg-orange-100 dark:bg-orange-900 rounded-full p-3">
                            <svg class="w-8 h-8 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Users by Role -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Users by Role
                    </h3>
                    <div class="space-y-3">
                        @php
                            $roleColors = [
                                'System Administrator' => 'bg-red-500',
                                'Psychometrician' => 'bg-blue-500',
                                'Guidance Counselor' => 'bg-green-500',
                                'Student' => 'bg-orange-500',
                            ];
                            $maxCount = $userStats['by_role']->max('count') ?: 1;
                        @endphp
                        @foreach($userStats['by_role'] as $role)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $role->role }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $role->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="{{ $roleColors[$role->role] ?? 'bg-gray-500' }} h-3 rounded-full transition-all duration-500" 
                                         style="width: {{ ($role->count / $maxCount) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($userStats['by_role']->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No user data available</p>
                        @endif
                    </div>
                </div>

                <!-- Results by Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        Results by Status
                    </h3>
                    <div class="space-y-3">
                        @php
                            $statusColors = [
                                'pending_counselor' => ['bg' => 'bg-yellow-500', 'label' => 'Pending Counselor'],
                                'counselor_reviewed' => ['bg' => 'bg-blue-500', 'label' => 'Counselor Reviewed'],
                                'completed' => ['bg' => 'bg-green-500', 'label' => 'Completed'],
                                'returned' => ['bg' => 'bg-red-500', 'label' => 'Returned'],
                            ];
                            $maxResult = $resultsByStatus->max('count') ?: 1;
                        @endphp
                        @foreach($resultsByStatus as $result)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $statusColors[$result->status]['label'] ?? ucfirst(str_replace('_', ' ', $result->status)) }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $result->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="{{ $statusColors[$result->status]['bg'] ?? 'bg-gray-500' }} h-3 rounded-full transition-all duration-500"
                                         style="width: {{ ($result->count / $maxResult) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($resultsByStatus->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No results data available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Registration Trend -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    User Registration Trend (Last 6 Months)
                </h3>
                @if($registrationTrend->isNotEmpty())
                    @php $maxReg = $registrationTrend->max('count') ?: 1; @endphp
                    <div class="flex items-end justify-between gap-2" style="height: 200px;">
                        @foreach($registrationTrend as $month)
                            <div class="flex-1 flex flex-col items-center justify-end h-full">
                                <span class="text-xs font-bold text-gray-900 dark:text-white mb-1">{{ $month->count }}</span>
                                <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg transition-all duration-500"
                                     style="height: {{ max(($month->count / $maxReg) * 160, 8) }}px;"></div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ \Carbon\Carbon::parse($month->month)->format('M') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">No registration data for the last 6 months</p>
                @endif
            </div>

            <!-- Exam Details & System Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Exam Details -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Exam Overview
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Total Exams</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $examStats['total'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Active Exams</span>
                            <span class="font-bold text-green-600">{{ $examStats['active'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Inactive Exams</span>
                            <span class="font-bold text-gray-500">{{ $examStats['inactive'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Total Sections</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $examStats['total_sections'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600 dark:text-gray-400">Total Questions</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $examStats['total_questions'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Activity
                    </h3>
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        @forelse($recentActivity as $activity)
                            <div class="flex items-start gap-3 py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold mt-0.5">
                                    {{ $activity->user ? strtoupper(substr($activity->user->name, 0, 1)) : 'S' }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-900 dark:text-white">
                                        <span class="font-medium">{{ $activity->user?->name ?? 'System' }}</span>
                                        — {{ $activity->description }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent activity</p>
                        @endforelse
                    </div>
                    @if($recentActivity->isNotEmpty())
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.audit.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All Activity →</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

