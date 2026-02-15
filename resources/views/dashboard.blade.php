<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->hasRole('admin'))
                @include('dashboard.admin')
            @elseif(Auth::user()->hasRole('psychometrician'))
                @include('dashboard.psychometrician')
            @elseif(Auth::user()->hasRole('counselor'))
                @include('dashboard.counselor')
            @elseif(Auth::user()->hasRole('student'))
                @include('dashboard.student')
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
