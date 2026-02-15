<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <!-- User Avatar & Name -->
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                        <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $user->role->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <p class="mt-1">
                            @if($user->deleted_at)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Inactive</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Active</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email Verified</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y H:i') : 'Not verified' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Edit User
                    </a>
                    @if($user->id !== auth()->id())
                        @if($user->deleted_at)
                            <form method="POST" action="{{ route('admin.users.restore', $user) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    Restore
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                  onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    Deactivate
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
