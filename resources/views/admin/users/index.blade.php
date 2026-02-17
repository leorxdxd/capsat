<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="bg-sisc-purple hover:bg-violet-900 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg transition-all flex items-center text-sm font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="hidden sm:inline">Create User</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative flex items-center gap-3 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg relative flex items-center gap-3 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Name or email..." 
                               class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                        <select name="role" class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-sisc-gold hover:bg-amber-500 text-white px-4 py-2.5 rounded-lg transition-all font-bold shadow-sm hover:shadow-md">
                            Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-lg transition-colors font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden md:block bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-sisc-purple text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">User</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-sisc-gold">Created</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-sisc-gold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-sisc-purple to-violet-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border 
                                        {{ $user->role->slug === 'admin' ? 'bg-purple-50 text-purple-800 border-purple-100' : 
                                            ($user->role->slug === 'psychometrician' ? 'bg-blue-50 text-blue-800 border-blue-100' : 
                                            ($user->role->slug === 'counselor' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : 
                                            'bg-gray-100 text-gray-600 border-gray-200')) }}">
                                        {{ $user->role->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->deleted_at)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-50 text-red-600 border border-red-100">
                                            Inactive
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors" title="Edit User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <!-- Impersonate Button -->
                                        @if(auth()->user()->id !== $user->id && !$user->hasRole('admin'))
                                            <form method="POST" action="{{ route('admin.users.impersonate', $user) }}" class="inline-block" onsubmit="return confirm('Login as {{ $user->name }}?');">
                                                @csrf
                                                <button type="submit" class="p-2 bg-purple-50 text-sisc-purple rounded-lg hover:bg-purple-100 transition-colors" title="Login as User">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Deactivate User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="font-medium">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden space-y-4">
                @forelse($users as $user)
                    <div class="bg-white rounded-lg shadow-md p-5 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-sisc-purple to-violet-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm text-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            @if($user->deleted_at)
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-50 text-red-600 border border-red-100">Inactive</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Active</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="px-2.5 py-1 font-bold rounded-full border
                                    {{ $user->role->slug === 'admin' ? 'bg-purple-50 text-purple-800 border-purple-100' : 
                                        ($user->role->slug === 'psychometrician' ? 'bg-blue-50 text-blue-800 border-blue-100' : 
                                        ($user->role->slug === 'counselor' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : 
                                        'bg-gray-50 text-gray-600 border-gray-100')) }}">
                                    {{ $user->role->name }}
                                </span>
                                <span class="text-gray-400 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm font-bold">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-sisc-purple">Edit</a>
                                @if($user->deleted_at)
                                    <form method="POST" action="{{ route('admin.users.restore', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-emerald-600">Restore</button>
                                    </form>
                                @else
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                              onsubmit="return confirm('Deactivate this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500">Deactivate</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 from-gray-50 to-white bg-gradient-to-b rounded-lg border border-gray-100">
                        <p class="text-gray-500 font-medium">No users found</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

