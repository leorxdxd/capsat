<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative flex items-center gap-3 shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" style="color: var(--sisc-gold, #F59E0B);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- General Settings -->
                <div class="w-full bg-white rounded-lg shadow-lg p-8 mb-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-3">
                        <svg class="w-6 h-6 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        General Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">System Name (Login)</label>
                            <input type="text" name="settings[system_name]" 
                                   value="{{ old('settings.system_name', $settings['general']['system_name'] ?? 'SISC Entrance Examination System') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">System Title (Subtitle)</label>
                            <input type="text" name="settings[system_title]" 
                                   value="{{ old('settings.system_title', $settings['general']['system_title'] ?? 'Basic Education Department') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">System Logo</label>
                            <div class="flex items-center gap-4">
                                @if(isset($settings['general']['system_logo']))
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200 p-2">
                                        <img src="{{ $settings['general']['system_logo'] }}" alt="Current Logo" class="max-w-full max-h-full">
                                    </div>
                                @endif
                                <input type="file" name="settings[system_logo]" accept="image/*"
                                       class="w-full rounded-lg border border-gray-300 p-2 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold"
                                       style="--file-bg: color-mix(in srgb, var(--sisc-purple), transparent 90%); --file-text: var(--sisc-purple);"
                                       onmouseover="this.style.setProperty('--file-bg-hover', 'color-mix(in srgb, var(--sisc-purple), transparent 80%)')">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Recommended size: Square (e.g., 512x512px). Max size: 2MB.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institution Name</label>
                            <input type="text" name="settings[institution_name]" 
                                   value="{{ old('settings.institution_name', $settings['general']['institution_name'] ?? 'Southville International School and Colleges') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Contact Email</label>
                            <input type="email" name="settings[contact_email]" 
                                   value="{{ old('settings.contact_email', $settings['general']['contact_email'] ?? 'admissions@southville.edu.ph') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Academic Year</label>
                            <input type="text" name="settings[academic_year]" 
                                   value="{{ old('settings.academic_year', $settings['general']['academic_year'] ?? '2025-2026') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Primary Theme Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="settings[system_primary_color]" 
                                       value="{{ old('settings.system_primary_color', $settings['general']['system_primary_color'] ?? '#2E1065') }}"
                                       class="w-12 h-10 p-1 rounded-lg border border-gray-300 cursor-pointer">
                                <input type="text" name="settings[system_primary_color_text]" 
                                       value="{{ old('settings.system_primary_color', $settings['general']['system_primary_color'] ?? '#2E1065') }}"
                                       class="flex-1 rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow text-xs font-mono uppercase"
                                       oninput="this.previousElementSibling.value = this.value">
                            </div>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Accent Theme Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="settings[system_accent_color]" 
                                       value="{{ old('settings.system_accent_color', $settings['general']['system_accent_color'] ?? '#F59E0B') }}"
                                       class="w-12 h-10 p-1 rounded-lg border border-gray-300 cursor-pointer">
                                <input type="text" name="settings[system_accent_color_text]" 
                                       value="{{ old('settings.system_accent_color', $settings['general']['system_accent_color'] ?? '#F59E0B') }}"
                                       class="flex-1 rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow text-xs font-mono uppercase"
                                       oninput="this.previousElementSibling.value = this.value">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Settings -->
                <div class="w-full bg-white rounded-lg shadow-lg p-8 mb-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-3">
                        <svg class="w-6 h-6 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exam Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Default Time Limit (minutes)</label>
                            <input type="number" name="settings[exam_default_time_limit]" 
                                   value="{{ old('settings.exam_default_time_limit', $settings['exam']['exam_default_time_limit'] ?? 60) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Passing Score (%)</label>
                            <input type="number" name="settings[exam_passing_score]" 
                                   value="{{ old('settings.exam_passing_score', $settings['exam']['exam_passing_score'] ?? 75) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[exam_randomize_questions]" value="true"
                                   {{ old('settings.exam_randomize_questions', $settings['exam']['exam_randomize_questions'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-sisc-purple focus:ring-sisc-purple">
                            <label class="ml-2 text-sm font-medium text-gray-700">Randomize Question Order</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[exam_auto_submit]" value="true"
                                   {{ old('settings.exam_auto_submit', $settings['exam']['exam_auto_submit'] ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-sisc-purple focus:ring-sisc-purple">
                            <label class="ml-2 text-sm font-medium text-gray-700">Auto-submit on Time Expiry</label>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="w-full bg-white rounded-lg shadow-lg p-8 mb-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-sisc-purple mb-6 flex items-center border-b border-gray-100 pb-3">
                        <svg class="w-6 h-6 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Security Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Session Timeout (minutes)</label>
                            <input type="number" name="settings[security_session_timeout]" 
                                   value="{{ old('settings.security_session_timeout', $settings['security']['security_session_timeout'] ?? 120) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Max Login Attempts</label>
                            <input type="number" name="settings[security_max_login_attempts]" 
                                   value="{{ old('settings.security_max_login_attempts', $settings['security']['security_max_login_attempts'] ?? 5) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password Min Length</label>
                            <input type="number" name="settings[security_password_min_length]" 
                                   value="{{ old('settings.security_password_min_length', $settings['security']['security_password_min_length'] ?? 8) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-sisc-purple focus:ring focus:ring-purple-200 transition-shadow">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[security_require_email_verification]" value="true"
                                   {{ old('settings.security_require_email_verification', $settings['security']['security_require_email_verification'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-sisc-purple focus:ring-sisc-purple">
                            <label class="ml-2 text-sm font-medium text-gray-700">Require Email Verification</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-sisc-purple text-white rounded-lg transition-all font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5" style="--hover-bg: color-mix(in srgb, var(--sisc-purple), black 20%);" onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" onmouseout="this.style.backgroundColor=''">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

