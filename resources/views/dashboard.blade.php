<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="{{ Auth::user()->hasRole('admin') ? 'w-full' : 'max-w-[1600px]' }} mx-auto px-4 sm:px-6 lg:px-8">
            @if(Auth::user()->hasRole('admin'))
                @include('dashboard.admin')
            @elseif(Auth::user()->hasRole('psychometrician'))
                @include('dashboard.psychometrician')
            @elseif(Auth::user()->hasRole('counselor'))
                @include('dashboard.counselor')
            @elseif(Auth::user()->hasRole('student'))
                @include('dashboard.student')
            @else
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-8 text-center">
                    <div class="text-gray-900 font-bold text-lg">
                        {{ __("Welcome back! You're logged in.") }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

