<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('Registration Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-6 mb-8 flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="bg-emerald-100 rounded-lg p-3 mr-5 shadow-sm">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-emerald-900">Success! {{ $count }} students registered</h3>
                        <p class="text-emerald-700 font-medium mt-1">Below are the generated credentials. Please save or print this page as the passwords are only shown once.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="bg-white text-gray-700 border border-gray-300 px-5 py-2.5 rounded-lg font-bold text-sm flex items-center hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print List
                    </button>
                    <a href="{{ route('students.index') }}" class="bg-sisc-purple hover:bg-violet-900 text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center">
                        Done
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg run-animation overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-8 py-5">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Student Credentials
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email (Username)</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Password</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Grade Info</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($credentials as $cred)
                                <tr class="hover:bg-purple-50/50 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $cred['name'] }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-700 font-medium font-mono">
                                        {{ $cred['email'] }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <code class="bg-gray-100 px-3 py-1.5 rounded-lg text-sisc-purple font-bold font-mono text-sm border border-gray-200">
                                                {{ $cred['password'] }}
                                            </code>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900">{{ $cred['grade'] }}</span>
                                            <span class="text-xs text-gray-400 font-medium">{{ $cred['app_number'] }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center print:hidden">
                <p class="text-gray-500 text-sm font-medium">
                    Remind students to <strong>change their password</strong> and <strong>complete their profile</strong> after their first login.
                </p>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * { visibility: hidden; }
            .py-12, .py-12 * { visibility: visible; }
            .py-12 { position: absolute; left: 0; top: 0; width: 100%; }
            .print\:hidden { display: none !important; }
            button { display: none !important; }
        }
    </style>
</x-app-layout>

