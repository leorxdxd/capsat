<nav x-data="{ open: false }" class="bg-sisc-purple border-b border-purple-800 sticky top-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->hasRole('psychometrician'))
                        <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Students') }}
                        </x-nav-link>
                        <x-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Exams') }}
                        </x-nav-link>
                        <x-nav-link :href="route('norms.index')" :active="request()->routeIs('norms.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Norms') }}
                        </x-nav-link>
                        <x-nav-link :href="route('results.index')" :active="request()->routeIs('results.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Results') }}
                        </x-nav-link>
                        <x-nav-link :href="route('results.retakes.index')" :active="request()->routeIs('results.retakes.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Retakes') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->hasRole('student'))
                        <x-nav-link :href="route('my-profile.edit')" :active="request()->routeIs('my-profile.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('My Profile') }}
                        </x-nav-link>
                        <x-nav-link :href="route('student.exams.index')" :active="request()->routeIs('student.exams.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('My Exams') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->hasRole('counselor'))
                        <x-nav-link :href="route('counselor.index')" :active="request()->routeIs('counselor.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Reviews') }}
                        </x-nav-link>
                    @endif
                    
                    @if(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Users') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Settings') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.audit.index')" :active="request()->routeIs('admin.audit.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Audit Logs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.backup.index')" :active="request()->routeIs('admin.backup.*')" class="text-white hover:text-sisc-gold focus:text-sisc-gold border-transparent hover:border-sisc-gold focus:border-sisc-gold">
                            {{ __('Database Backups') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-white hover:text-sisc-gold focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-sisc-gold hover:bg-purple-800 focus:outline-none focus:bg-purple-800 focus:text-sisc-gold transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-purple-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->hasRole('psychometrician'))
                <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Students') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Exams') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('norms.index')" :active="request()->routeIs('norms.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Norms') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('results.index')" :active="request()->routeIs('results.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Results') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('results.retakes.index')" :active="request()->routeIs('results.retakes.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Retakes') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->hasRole('student'))
                <x-responsive-nav-link :href="route('my-profile.edit')" :active="request()->routeIs('my-profile.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('My Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('student.exams.index')" :active="request()->routeIs('student.exams.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('My Exams') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->hasRole('counselor'))
                <x-responsive-nav-link :href="route('counselor.index')" :active="request()->routeIs('counselor.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Reviews') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Users') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.audit.index')" :active="request()->routeIs('admin.audit.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Audit Logs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.backup.index')" :active="request()->routeIs('admin.backup.*')" class="text-white hover:text-sisc-gold hover:bg-purple-800 border-l-4 border-transparent hover:border-sisc-gold">
                    {{ __('Database Backups') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-purple-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-purple-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-purple-100 hover:text-white hover:bg-purple-800">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-purple-100 hover:text-white hover:bg-purple-800"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

