<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-sisc-purple font-bold text-sm transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-12">
            <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-100">
                <!-- User Avatar & Name -->
                <div class="flex items-center mb-8">
                    <div class="flex-shrink-0 h-20 w-20 bg-gradient-to-br from-sisc-purple to-violet-600 rounded-lg flex items-center justify-center text-white text-3xl font-extrabold shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-5">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-500 font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 bg-gray-50 rounded-lg p-6 border border-gray-100">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Role</label>
                        <p class="text-gray-900 font-bold text-lg flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-sisc-gold"></span>
                            {{ $user->role->name }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Status</label>
                        <p class="mt-1">
                            @if($user->deleted_at)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">Inactive</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Active</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Email Verified</label>
                        <p class="text-gray-900 font-medium">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y H:i') : 'Not verified' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Created</label>
                        <p class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-5 py-2.5 bg-sisc-purple hover:bg-violet-900 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        Edit User
                    </a>
                    @if($user->id !== auth()->id())
                        @if($user->deleted_at)
                            <form method="POST" action="{{ route('admin.users.restore', $user) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                    Restore User
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                  onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg font-bold text-sm transition-colors hover:border-red-300">
                                    Deactivate Account
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

