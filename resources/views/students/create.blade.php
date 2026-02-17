<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-sisc-purple leading-tight">
                {{ __('Register New Student') }}
            </h2>
            <a href="{{ route('students.index') }}" class="text-gray-500 hover:text-sisc-purple flex items-center text-sm font-bold transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-sisc-purple to-violet-900 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personal Information
                        </h3>
                        <p class="text-purple-200 text-sm mt-1">Enter the student's complete personal details</p>
                    </div>
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="Juan">
                                @error('first_name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="Santos">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="Dela Cruz">
                                @error('last_name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                                <select name="gender" required class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Applying for Grade Level <span class="text-red-500">*</span></label>
                                <select name="current_grade_level" required class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                    <option value="">Select Grade</option>
                                    @foreach(['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                        <option value="{{ $grade }}" {{ old('current_grade_level') === $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                    @endforeach
                                </select>
                                @error('current_grade_level') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">LRN (Learner Reference Number)</label>
                                <input type="text" name="lrn" value="{{ old('lrn') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="12-digit LRN">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Previous School</label>
                                <input type="text" name="previous_school" value="{{ old('previous_school') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="Name of previous school">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Address -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-sisc-purple flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Contact & Address
                        </h3>
                    </div>
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="student@email.com">
                                <p class="text-xs text-gray-500 mt-1">This will be used for the student's login account</p>
                                @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="09XX-XXX-XXXX">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Street Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="House/Block/Street/Barangay">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">City / Municipality</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="e.g. Quezon City">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Province</label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="e.g. Metro Manila">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-sisc-purple flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sisc-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Guardian / Parent Information
                        </h3>
                    </div>
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Guardian Full Name</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="Full name of guardian">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Relationship</label>
                                <select name="guardian_relationship" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow">
                                    <option value="">Select Relationship</option>
                                    @foreach(['Mother', 'Father', 'Guardian', 'Grandparent', 'Sibling', 'Other'] as $rel)
                                        <option value="{{ $rel }}" {{ old('guardian_relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Guardian Contact Number</label>
                                <input type="text" name="guardian_contact" value="{{ old('guardian_contact') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-sisc-purple focus:border-sisc-purple transition-shadow" placeholder="09XX-XXX-XXXX">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Notice -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-sm text-blue-800">
                            <p class="font-bold text-base mb-1">Account Creation Note</p>
                            <p>A student login account will be automatically created with the email provided. The default password is <strong>"password"</strong>. The student should change this on first login.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('students.index') }}" class="px-6 py-3 text-gray-600 font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-sisc-purple hover:bg-violet-900 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5">
                        Register Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

