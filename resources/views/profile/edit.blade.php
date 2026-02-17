<x-app-layout>
    <div class="w-full space-y-8 animate-fade-in-up p-4 sm:p-6 lg:p-8">
        
        {{-- Modern Hero Section --}}
        <div class="relative bg-gradient-to-br from-slate-800 to-indigo-900 rounded-lg shadow-2xl p-8 md:p-10 text-white overflow-hidden group">
            {{-- Abstract Shapes --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 bg-indigo-500/20 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold text-indigo-100 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        ACCOUNT SETTINGS
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-2 leading-tight">
                        My <span class="text-indigo-200">Profile</span>
                    </h2>
                    <p class="text-indigo-100/90 max-w-xl text-lg font-medium">
                        Manage your personal information, security, and preferences.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Identity & Navigation --}}
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden relative group">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                    <div class="p-6 relative pt-12">
                        <div class="w-24 h-24 mx-auto bg-white rounded-lg p-1.5 shadow-lg mb-4">
                            <div class="w-full h-full bg-indigo-50 rounded-lg flex items-center justify-center text-3xl font-black text-indigo-600">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                            <p class="text-indigo-500 font-medium text-sm mb-4">{{ auth()->user()->email }}</p>
                            
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                {{ ucfirst(auth()->user()->role->name) }}
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Member Since</p>
                                    <p class="font-bold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Status</p>
                                    <p class="font-bold text-emerald-600">Active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Digital Signature Preview --}}
                @if(auth()->user()->signature_path)
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Current Signature</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-dashed border-gray-200 flex items-center justify-center min-h-[100px]">
                        <img src="{{ Storage::url(auth()->user()->signature_path) }}" alt="Signature" class="max-h-16 opacity-80">
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column: Forms --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Profile Information --}}
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-8">
                         <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Personal Details</h3>
                        </div>
                        
                        {{-- Removed max-w-xl to allow full width adaptation --}}
                        <div class="w-full">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Security</h3>
                        </div>
                        
                        <div class="w-full">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Delete Account --}}
                <div class="bg-white rounded-lg shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Danger Zone</h3>
                        </div>
                        
                        <div class="w-full">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

