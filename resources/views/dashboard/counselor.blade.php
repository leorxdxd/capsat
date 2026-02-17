<div class="space-y-8 animate-fade-in-up">
    <!-- Welcome Hero Section -->
    <div class="relative bg-gradient-to-br from-sisc-purple to-violet-900 rounded-lg shadow-2xl p-8 md:p-12 text-white overflow-hidden group">
                <!-- Animated Background Elements -->
                <div class="absolute top-0 right-0 -mr-24 -mt-24 w-80 h-80 rounded-full bg-sisc-gold opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-64 h-64 rounded-full bg-purple-500 opacity-20 blur-3xl group-hover:scale-110 transition-transform duration-1000 delay-100"></div>
                <div class="absolute inset-0 bg-pattern opacity-5"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-purple-100">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            Counselor Portal
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                            Welcome back,<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-200">
                                {{ Auth::user()->name }}
                            </span>
                        </h1>

                        <p class="text-purple-100 text-lg max-w-xl leading-relaxed opacity-90">
                            You have <strong class="text-white">{{ $stats['pending'] }} pending reviews</strong> waiting for your expertise today.
                        </p>
                    </div>

                    <div class="hidden md:block">
                        <a href="{{ route('counselor.index') }}"
                           class="group relative inline-flex items-center gap-3 px-6 py-3 bg-white text-sisc-purple rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all overflow-hidden">
                            <span class="relative z-10">Start Reviewing</span>
                            <svg class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="absolute inset-0 bg-purple-50 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pending Card -->
                <div class="bg-white rounded-lg p-6 shadow-xl shadow-purple-900/5 border border-purple-50 hover:border-purple-100 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-wider">
                                Priority
                            </span>
                        </div>
                        <div class="space-y-1">
                            <p class="text-4xl font-black text-gray-900 tracking-tight group-hover:text-amber-600 transition-colors">
                                {{ $stats['pending'] }}
                            </p>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Pending Reviews</p>
                        </div>
                    </div>
                </div>

                <!-- Approved Card -->
                <div class="bg-white rounded-lg p-6 shadow-xl shadow-purple-900/5 border border-purple-50 hover:border-purple-100 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-wider">
                                This Month
                            </span>
                        </div>
                        <div class="space-y-1">
                            <p class="text-4xl font-black text-gray-900 tracking-tight group-hover:text-emerald-600 transition-colors">
                                {{ $stats['approved'] }}
                            </p>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Approved</p>
                        </div>
                    </div>
                </div>

                <!-- Total Card -->
                <div class="bg-white rounded-lg p-6 shadow-xl shadow-purple-900/5 border border-purple-50 hover:border-purple-100 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider">
                                Lifetime
                            </span>
                        </div>
                        <div class="space-y-1">
                            <p class="text-4xl font-black text-gray-900 tracking-tight group-hover:text-blue-600 transition-colors">
                                {{ $stats['total_reviewed'] }}
                            </p>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Reviews</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-sisc-purple rounded-full"></span>
                            Recent Incoming Reviews
                        </h2>
                        <a href="{{ route('counselor.index') }}" class="text-sm font-bold text-sisc-purple hover:text-violet-900 hover:underline">
                            View All &rarr;
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                        <div class="divide-y divide-gray-50">
                            @forelse($recentPending as $result)
                                <div class="p-5 hover:bg-gray-50 transition-all duration-200 group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center text-sisc-purple font-bold text-lg ring-4 ring-white shadow-sm group-hover:scale-105 transition-transform">
                                                {{ substr($result->student->first_name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 group-hover:text-sisc-purple transition-colors text-base">
                                                    {{ $result->student->full_name ?? 'Unknown Student' }}
                                                </h4>
                                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-0.5">
                                                    {{ $result->exam->title }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="text-right hidden sm:block">
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Score</p>
                                                <p class="font-black text-gray-900">{{ $result->raw_score }}</p>
                                            </div>
                                            <a href="{{ route('counselor.show', $result) }}" class="p-2 text-gray-400 hover:text-sisc-purple hover:bg-purple-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-10 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">All Caught Up!</h3>
                                    <p class="text-sm text-gray-500 mt-1">No pending reviews at the moment.</p>
                                </div>
                            @endforelse
                        </div>

                        @if($recentPending->count() > 0)
                            <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                                <a href="{{ route('counselor.index') }}" class="text-xs font-bold text-gray-500 hover:text-sisc-purple uppercase tracking-widest transition-colors">
                                    View All Pending Reviews
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar (1/3) -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                            <span class="w-1.5 h-6 bg-sisc-gold rounded-full"></span>
                            Quick Actions
                        </h2>

                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('counselor.index') }}" class="flex items-center p-4 bg-white rounded-lg shadow-lg shadow-purple-900/5 hover:shadow-xl border border-gray-100 hover:border-purple-200 transition-all group">
                                <div class="w-12 h-12 rounded-lg bg-purple-50 text-sisc-purple flex items-center justify-center group-hover:scale-110 group-hover:bg-sisc-purple group-hover:text-white transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-bold text-gray-900">Start Reviewing</p>
                                    <p class="text-xs text-gray-500 group-hover:text-sisc-purple transition-colors">Process pending exams</p>
                                </div>
                            </a>

                            <a href="{{ route('counselor.history') }}" class="flex items-center p-4 bg-white rounded-lg shadow-lg shadow-purple-900/5 hover:shadow-xl border border-gray-100 hover:border-purple-200 transition-all group">
                                <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-bold text-gray-900">View History</p>
                                    <p class="text-xs text-gray-500 group-hover:text-blue-600 transition-colors">Past signed results</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Calendar Widget (Mock) -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-lg p-6 text-white shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-white opacity-10 blur-2xl"></div>

                        <div class="flex items-center justify-between mb-6 relative z-10">
                            <h3 class="font-bold text-lg">Today's Focus</h3>
                            <span class="text-xs font-bold px-2 py-1 rounded bg-white/20">{{ now()->format('M d') }}</span>
                        </div>

                        <div class="space-y-4 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-10 rounded-full bg-sisc-gold"></div>
                                <div>
                                    <p class="text-sm font-bold">Review High Priority</p>
                                    <p class="text-xs text-gray-400">3 students pending &gt; 2 days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-10 rounded-full bg-purple-400"></div>
                                <div>
                                    <p class="text-sm font-bold">Team Meeting</p>
                                    <p class="text-xs text-gray-400">2:00 PM - Conference Room</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10">
                            <p class="text-xs text-gray-400 text-center italic">"Excellence in every action"</p>
                        </div>
                    </div>
                </div>
            </div>
</div>

