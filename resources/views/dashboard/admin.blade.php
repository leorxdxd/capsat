<div class="space-y-8 animate-fade-in-up">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-br from-sisc-purple to-violet-900 rounded-lg shadow-xl p-8 md:p-12 text-white relative overflow-hidden group">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-sisc-gold opacity-10 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-purple-500 opacity-20 blur-2xl group-hover:scale-110 transition-transform duration-1000"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-purple-100 mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Admin Console
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Welcome Back, {{ Auth::user()->name }}</h1>
                    <p class="text-purple-100 max-w-xl">System Administrator Dashboard</p>
                </div>
                
                <div class="hidden md:block">
                     <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg backdrop-blur-sm transition-colors text-sm font-medium border border-white/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Total Users -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-3 text-sisc-purple">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Students -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Students</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::whereHas('role', function($q) { $q->where('slug', 'student'); })->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3 text-sisc-gold">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Staff -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Staff Member</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::whereHas('role', function($q) { $q->whereIn('slug', ['admin', 'psychometrician', 'counselor']); })->count() }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-3 text-sisc-purple">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- System Health -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">System Status</p>
                        <p class="text-xl font-bold text-green-600 mt-1">Operational</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Active Exams (New for Admin Oversight) -->
            <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Active Exams</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeExams }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-sisc-gold rounded-full"></span>
                    Administrative Actions
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-purple-50 border border-gray-100 transition-colors group">
                        <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-sisc-purple group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-sisc-purple">Manage Users</p>
                            <p class="text-xs text-gray-500">Add, edit, or remove users</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-purple-50 border border-gray-100 transition-colors group">
                        <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-sisc-purple group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-sisc-purple">System Settings</p>
                            <p class="text-xs text-gray-500">Configure app settings</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-sisc-gold rounded-full"></span>
                    Recent Activity
                </h3>
                <div class="space-y-4">
                    @forelse($activities as $activity)
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-sisc-purple shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900">
                                    <strong>{{ $activity->user->name ?? 'System' }}</strong>: 
                                    <span class="text-gray-600">{{ $activity->action }}</span>
                                </p>
                                <p class="text-xs text-gray-500">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            No recent activity found.
                        </div>
                    @endforelse
                </div>
                </div>
            </div>

            <!-- Recent Global Results (New for Admin Oversight) -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-500 rounded-full"></span>
                    Recent Exam Results
                </h3>
                <div class="space-y-4">
                    @forelse($recentResults as $result)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm shrink-0">
                                    {{ substr($result->student->first_name, 0, 1) }}{{ substr($result->student->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $result->student->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $result->exam->title }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    @if($result->status === 'official') bg-emerald-100 text-emerald-800
                                    @elseif($result->status === 'counselor_approved') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                                </span>
                                <p class="text-[10px] text-gray-400 mt-1">{{ $result->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            No recent exam submissions.
                        </div>
                    @endforelse
    </div>
</div>

