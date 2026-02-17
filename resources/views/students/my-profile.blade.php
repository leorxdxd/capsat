<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-sisc-purple leading-tight">My Profile</h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-emerald-800 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @php
                $isIncomplete = !$student->date_of_birth || !$student->gender || !$student->address || !$student->guardian_name;
            @endphp

            @if ($isIncomplete)
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="text-amber-900 font-bold text-lg">Complete Your Profile</p>
                            <p class="text-amber-800 text-sm mt-1">Please fill in your missing information below. Your profile needs complete details for the entrance exam process.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('my-profile.update') }}" class="space-y-6">
                @csrf @method('PUT')

                <!-- Account Information -->
                <div class="bg-white rounded-lg shadow-lg run-animation overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            Account Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $student->user->email) }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-shadow">
                                <p class="text-xs text-gray-500 mt-1.5 font-medium">You can use your personal email or SGEN email. You may change this anytime.</p>
                                @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Application Number</label>
                                <input type="text" value="{{ $student->application_number }}" disabled
                                       class="w-full border-gray-200 bg-gray-50 text-gray-500 font-mono font-bold rounded-lg cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow-lg run-animation overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-sisc-purple to-violet-800 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-3 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personal Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                @error('first_name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                @error('last_name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Gender <span class="text-red-500">*</span></label>
                                <select name="gender" required class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Grade Level</label>
                                <input type="text" value="{{ $student->current_grade_level }}" disabled
                                       class="w-full border-gray-200 bg-gray-50 text-gray-500 font-bold rounded-lg cursor-not-allowed">
                                <p class="text-xs text-gray-400 mt-1.5 font-medium">Contact psychometrician to change</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">LRN (Learner Reference Number)</label>
                                <input type="text" name="lrn" value="{{ old('lrn', $student->lrn) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow"
                                       placeholder="12-digit LRN">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Previous School</label>
                                <input type="text" name="previous_school" value="{{ old('previous_school', $student->previous_school) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Address -->
                <div class="bg-white rounded-lg shadow-lg run-animation overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-sisc-gold to-yellow-500 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center shadow-sm">
                            <svg class="w-5 h-5 mr-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Contact & Address
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-gold focus:border-sisc-gold transition-shadow"
                                   placeholder="09XX-XXX-XXXX">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Street Address</label>
                            <input type="text" name="address" value="{{ old('address', $student->address) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-gold focus:border-sisc-gold transition-shadow">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">City / Municipality</label>
                                <input type="text" name="city" value="{{ old('city', $student->city) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-gold focus:border-sisc-gold transition-shadow">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Province</label>
                                <input type="text" name="province" value="{{ old('province', $student->province) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-gold focus:border-sisc-gold transition-shadow">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="bg-white rounded-lg shadow-lg run-animation overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Guardian / Parent Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Guardian Full Name</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition-shadow">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Relationship</label>
                                <select name="guardian_relationship" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition-shadow">
                                    <option value="">Select Relationship</option>
                                    @foreach(['Mother', 'Father', 'Guardian', 'Grandparent', 'Sibling', 'Other'] as $rel)
                                        <option value="{{ $rel }}" {{ old('guardian_relationship', $student->guardian_relationship) === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Guardian Contact</label>
                                <input type="text" name="guardian_contact" value="{{ old('guardian_contact', $student->guardian_contact) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition-shadow">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-4 pb-10">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-gray-600 font-bold text-sm rounded-lg hover:bg-gray-100 transition-colors">
                        Back to Dashboard
                    </a>
                    <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Save My Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

