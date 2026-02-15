<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <!-- General Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        General Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">System Name</label>
                            <input type="text" name="settings[system_name]" 
                                   value="{{ $settings['general']['system_name'] ?? 'SISC Entrance Examination System' }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institution Name</label>
                            <input type="text" name="settings[institution_name]" 
                                   value="{{ $settings['general']['institution_name'] ?? 'Southville International School and Colleges' }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Email</label>
                            <input type="email" name="settings[contact_email]" 
                                   value="{{ $settings['general']['contact_email'] ?? 'admissions@southville.edu.ph' }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Academic Year</label>
                            <input type="text" name="settings[academic_year]" 
                                   value="{{ $settings['general']['academic_year'] ?? '2025-2026' }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Exam Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exam Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Default Time Limit (minutes)</label>
                            <input type="number" name="settings[exam_default_time_limit]" 
                                   value="{{ $settings['exam']['exam_default_time_limit'] ?? 60 }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Passing Score (%)</label>
                            <input type="number" name="settings[exam_passing_score]" 
                                   value="{{ $settings['exam']['exam_passing_score'] ?? 75 }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[exam_randomize_questions]" value="true"
                                   {{ ($settings['exam']['exam_randomize_questions'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500">
                            <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Randomize Question Order</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[exam_auto_submit]" value="true"
                                   {{ ($settings['exam']['exam_auto_submit'] ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500">
                            <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Auto-submit on Time Expiry</label>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Security Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session Timeout (minutes)</label>
                            <input type="number" name="settings[security_session_timeout]" 
                                   value="{{ $settings['security']['security_session_timeout'] ?? 120 }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Login Attempts</label>
                            <input type="number" name="settings[security_max_login_attempts]" 
                                   value="{{ $settings['security']['security_max_login_attempts'] ?? 5 }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Min Length</label>
                            <input type="number" name="settings[security_password_min_length]" 
                                   value="{{ $settings['security']['security_password_min_length'] ?? 8 }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[security_require_email_verification]" value="true"
                                   {{ ($settings['security']['security_require_email_verification'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500">
                            <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Require Email Verification</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
