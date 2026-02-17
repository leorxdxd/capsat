<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $systemName ?? 'CAPSAT' }}</title>

        {{-- Favicon --}}
        <link rel="icon" type="image/x-icon" href="{{ $systemLogo ?? asset('favicon.ico') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dynamic Theme Colors -->
        <style>
            :root {
                --sisc-purple: {{ $primaryColor ?? '#2E1065' }};
                --sisc-gold: {{ $accentColor ?? '#F59E0B' }};
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
            
            <!-- Background Decorative Elements -->
            <div class="absolute inset-0 z-0">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full blur-3xl" style="background: radial-gradient(circle, color-mix(in srgb, var(--sisc-gold), transparent 80%) 0%, color-mix(in srgb, var(--sisc-gold), transparent 90%) 100%);"></div>
                <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] rounded-full blur-3xl" style="background: radial-gradient(circle, color-mix(in srgb, var(--sisc-purple), transparent 80%) 0%, color-mix(in srgb, var(--sisc-purple), transparent 90%) 100%);"></div>
            </div>

            <!-- Main Content -->
            <div class="z-10 w-full max-w-4xl px-6 text-center">
                
                <!-- Logo / Title -->
                <div class="mb-8 animate-fade-in-up">
                    <div class="w-24 h-24 mx-auto rounded-lg flex items-center justify-center shadow-xl mb-6 transform hover:scale-105 transition-transform duration-300" 
                         style="background: linear-gradient(135deg, var(--sisc-purple), color-mix(in srgb, var(--sisc-purple), black 20%));">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-4">
                        <span class="text-sisc-purple">CAPSAT</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        Begin your academic journey with excellence. Secure, efficient, and streamlined assessment platform.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up animation-delay-200">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-sisc-purple text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2"
                               style="--hover-bg: color-mix(in srgb, var(--sisc-purple), black 20%);" onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" onmouseout="this.style.backgroundColor=''">
                                <span>Go to Dashboard</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-sisc-purple text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1"
                               style="--hover-bg: color-mix(in srgb, var(--sisc-purple), black 20%);" onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" onmouseout="this.style.backgroundColor=''">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-sisc-purple border-2 border-purple-100 hover:border-sisc-purple font-bold rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
                
                <!-- Footer Info -->
                <div class="mt-16 text-sm text-gray-500 animate-fade-in-up animation-delay-400">
                    <p>&copy; {{ date('Y') }} Southville International School and Colleges. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>

