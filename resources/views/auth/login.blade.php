<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — SISC Entrance Exam</title>
    <meta name="description" content="SISC Basic Education Entrance Examination System — Secure login portal for students, counselors, and administrators.">

    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dynamic Theme Colors -->
    <style>
        :root {
            --sisc-purple: {{ $primaryColor ?? '#2E1065' }};
            --sisc-gold: {{ $accentColor ?? '#F59E0B' }};
        }
    </style>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Figtree', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ══════════════════════════════════════════════
           LAYOUT
           ══════════════════════════════════════════════ */
        .page {
            display: flex;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }

        .panel-left {
            flex: 0 0 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 48px;
            overflow: hidden;
            background: var(--sisc-purple, #4C1D95);
        }

        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 40px;
            background: #fafbfc;
            overflow: hidden;
        }

        @media (max-width: 960px) {
            .panel-left { display: none; }
            .panel-right { padding: 24px 20px; background: #fafbfc; }
        }

        /* ══════════════════════════════════════════════
           LEFT PANEL — SISC Branding
           ══════════════════════════════════════════════ */

        /* Mesh gradient background */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 90%, color-mix(in srgb, var(--sisc-gold, #F59E0B), transparent 65%), transparent),
                radial-gradient(ellipse 60% 50% at 80% 10%, color-mix(in srgb, var(--sisc-purple, #4C1D95), white 20%), transparent),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(255,255,255,0.1), transparent);
            z-index: 0;
        }

        /* Soft glow orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .orb-1 {
            width: 400px; height: 400px;
            background: color-mix(in srgb, var(--sisc-gold, #F59E0B), transparent 80%);
            top: -100px; right: -80px;
            animation: drift 20s ease-in-out infinite;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: color-mix(in srgb, var(--sisc-purple, #4C1D95), white 20%);
            bottom: -60px; left: -60px;
            animation: drift 25s ease-in-out infinite reverse;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.1);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 15px) scale(0.95); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 1; transform: translate(-50%, -50%) scale(1.2); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }

        .panel-left-content {
            position: relative;
            z-index: 2;
        }

        /* Brand section */
        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--sisc-gold, #F59E0B), color-mix(in srgb, var(--sisc-gold, #F59E0B), white 20%));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px color-mix(in srgb, var(--sisc-gold, #F59E0B), transparent 70%);
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: rgba(255,255,255,0.95);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Heading */
        .hero-heading {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.1;
            color: white;
            margin-bottom: 14px;
            letter-spacing: -1px;
        }

        .hero-heading span {
            color: var(--sisc-gold, #F59E0B);
        }

        .hero-sub {
            font-size: 15px;
            color: rgba(255,255,255,0.8);
            line-height: 1.6;
            max-width: 400px;
        }

        /* Feature badges */
        .features {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 32px;
        }

        .feature-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .feature-pip {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-pip svg {
            color: var(--sisc-gold, #F59E0B);
        }

        .feature-text h4 {
            font-size: 14px;
            font-weight: 700;
            color: white;
        }

        .feature-text p {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }

        /* Toggle eye */
        .eye-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .eye-toggle:hover { color: var(--sisc-purple, #4C1D95); }

        /* ══════════════════════════════════════════════
           RIGHT PANEL — Form
           ══════════════════════════════════════════════ */
        .form-container {
            width: 100%;
            max-width: 400px;
        }

        /* Mobile header */
        .mobile-brand {
            display: none;
            text-align: center;
            margin-bottom: 20px;
        }

        .mobile-brand .m-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--sisc-purple, #4C1D95), color-mix(in srgb, var(--sisc-purple, #4C1D95), black 20%));
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 8px 24px color-mix(in srgb, var(--sisc-purple, #4C1D95), transparent 75%);
        }

        .mobile-brand h2 {
            font-size: 18px;
            font-weight: 800;
            color: #1f2937;
        }

        .mobile-brand p {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        @media (max-width: 960px) {
            .mobile-brand { display: block; }
        }

        .form-title {
            font-size: 22px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .form-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        /* Input fields */
        .field {
            margin-bottom: 14px;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .field-wrap:focus-within .field-icon {
            color: var(--sisc-purple, #4C1D95);
        }

        .field-input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            font-size: 15px;
            font-family: inherit;
            font-weight: 500;
            color: #111827;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }

        .field-input::placeholder {
            color: #d1d5db;
            font-weight: 400;
        }

        .field-input:focus {
            border-color: var(--sisc-purple, #4C1D95);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--sisc-purple, #4C1D95), transparent 92%), 0 1px 2px rgba(0,0,0,0.04);
        }

        /* Checkbox */
        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #4b5563;
        }

        .check-box {
            width: 18px; height: 18px;
            border-radius: 5px;
            border: 2px solid #d1d5db;
            appearance: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .check-box:checked {
            background: var(--sisc-gold, #F59E0B);
            border-color: var(--sisc-gold, #F59E0B);
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E");
            background-size: 14px;
            background-position: center;
            background-repeat: no-repeat;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--sisc-purple, #4C1D95);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: color-mix(in srgb, var(--sisc-purple, #4C1D95), black 20%); }

        /* Submit button */
        .btn-sign-in {
            width: 100%;
            padding: 13px 24px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--sisc-purple, #4C1D95) 0%, color-mix(in srgb, var(--sisc-purple, #4C1D95), black 10%) 50%, var(--sisc-purple, #4C1D95) 100%);
            background-size: 200% 200%;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            letter-spacing: 0.3px;
        }

        .btn-sign-in:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px color-mix(in srgb, var(--sisc-purple, #4C1D95), transparent 75%);
            background-position: 100% 100%;
        }

        .btn-sign-in:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px color-mix(in srgb, var(--sisc-purple, #4C1D95), transparent 80%);
        }

        .btn-sign-in .btn-shimmer {
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.7s ease;
        }

        .btn-sign-in:hover .btn-shimmer {
            left: 100%;
        }

        .btn-sign-in .btn-content {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            gap: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Error box */
        .error-box {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fef2f2, #fff1f2);
            border: 1px solid #fecdd3;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-box svg { flex-shrink: 0; }
        .error-box p { color: #e11d48; font-size: 14px; font-weight: 500; }

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid #f3f4f6;
        }

        .form-footer p {
            font-size: 11px;
            color: #9ca3af;
        }

        .form-footer .school-name {
            font-weight: 700;
            color: var(--sisc-purple, #4C1D95);
        }

        /* ══════════════════════════════════════════════
           ANIMATIONS
           ══════════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .anim { animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .anim-d1 { animation-delay: 0.05s; }
        .anim-d2 { animation-delay: 0.12s; }
        .anim-d3 { animation-delay: 0.19s; }
        .anim-d4 { animation-delay: 0.26s; }
        .anim-d5 { animation-delay: 0.33s; }
        .anim-d6 { animation-delay: 0.40s; }
        .anim-d7 { animation-delay: 0.47s; }

        /* Left panel stagger */
        .left-anim { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .left-d1 { animation-delay: 0.1s; }
        .left-d2 { animation-delay: 0.25s; }
        .left-d3 { animation-delay: 0.4s; }
        .left-d4 { animation-delay: 0.55s; }

        /* ══════════════════════════════════════════════
           MOBILE-SPECIFIC
           ══════════════════════════════════════════════ */
        @media (max-width: 960px) {
            .form-container { max-width: 100%; }
            .form-title { font-size: 20px; }
            .form-subtitle { margin-bottom: 16px; }
            .field { margin-bottom: 12px; }
            .field-input { padding: 11px 14px 11px 44px; font-size: 15px; }
            .meta-row { margin-bottom: 14px; }
            .btn-sign-in { padding: 12px; }
            .form-footer { margin-top: 16px; padding-top: 12px; }
        }

        @media (max-width: 380px) {
            .panel-right { padding: 16px 16px; }
            .mobile-brand { margin-bottom: 14px; }
            .mobile-brand .m-icon { width: 40px; height: 40px; margin-bottom: 8px; }
            .mobile-brand h2 { font-size: 16px; }
            .form-title { font-size: 18px; }
            .form-subtitle { font-size: 12px; margin-bottom: 12px; }
            .field { margin-bottom: 10px; }
            .field-label { font-size: 11px; margin-bottom: 5px; }
            .field-input { padding: 10px 14px 10px 42px; font-size: 16px; border-radius: 10px; }
            .meta-row { margin-bottom: 12px; }
            .check-label { font-size: 12px; }
            .forgot-link { font-size: 12px; }
            .btn-sign-in { padding: 11px; font-size: 13px; border-radius: 10px; }
            .form-footer { margin-top: 12px; padding-top: 10px; }
            .form-footer p { font-size: 10px; }
        }
    </style>
</head>
<body>
    <div class="page">

        {{-- ════════════════════════════════════════════
             LEFT — Premium purple brand panel
             ════════════════════════════════════════════ --}}
        <div class="panel-left">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
            <div class="grid-overlay"></div>

            {{-- Top: Brand --}}
            <div class="panel-left-content">
                <div class="brand-mark left-anim left-d1">
                    <div class="brand-icon" style="{{ $systemLogo ? 'background: none; box-shadow: none; width: 64px; height: 64px;' : 'width: 64px; height: 64px;' }}">
                        @if($systemLogo)
                            <img src="{{ $systemLogo }}" alt="Logo" class="w-16 h-16 object-contain">
                        @else
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        @endif
                    </div>
                    <span class="brand-name" style="font-size: 20px;">{{ $systemName }}</span>
                </div>

                {{-- Heading --}}
                <div class="left-anim left-d2">
                    <h1 class="hero-heading">
                        {{ $systemName }}<br><span>{{ $systemTitle }}</span>
                    </h1>
                    <p class="hero-sub">
                        A comprehensive platform for managing entrance assessments, results, and student evaluations at SISC Basic Education.
                    </p>
                </div>

                {{-- Features --}}
                <div class="features left-anim left-d3">
                    <div class="feature-row">
                        <div class="feature-pip">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"></path>
                                <path fill="#2E1065" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h4>Secure Online Assessments</h4>
                            <p>Timed exams with anti-cheating measures</p>
                        </div>
                    </div>

                    <div class="feature-row">
                        <div class="feature-pip">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h4>Automated Scoring & Norms</h4>
                            <p>Instant results with performance interpretations</p>
                        </div>
                    </div>

                    <div class="feature-row">
                        <div class="feature-pip">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h4>Official PDF Reports</h4>
                            <p>Digitally signed documents for records</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════════
             RIGHT — Login Form
             ════════════════════════════════════════════ --}}
        <div class="panel-right">
            <div class="form-container">

                {{-- Mobile brand (visible on small screens) --}}
                <div class="mobile-brand anim anim-d1">
                    <div class="m-icon" style="{{ $systemLogo ? 'background: none; box-shadow: none;' : '' }}">
                        @if($systemLogo)
                            <img src="{{ $systemLogo }}" alt="Logo" class="w-10 h-10 object-contain">
                        @else
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        @endif
                    </div>
                    <h2>{{ $systemName }}</h2>
                    <p>{{ $systemTitle }}</p>
                </div>

                {{-- Greeting --}}
                <h2 class="form-title anim anim-d2">Welcome back</h2>
                <p class="form-subtitle anim anim-d2">Sign in to your account to continue</p>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="error-box anim">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="field anim anim-d3">
                        <label class="field-label" for="email">Email</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="field-input" placeholder="your@email.com"
                                required autofocus autocomplete="username" />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="field anim anim-d4" x-data="{ show: false }">
                        <label class="field-label" for="password">Password</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password"
                                class="field-input" placeholder="••••••••" style="padding-right: 48px;"
                                required autocomplete="current-password" />
                            <button type="button" class="eye-toggle" @click="show = !show" tabindex="-1" title="Toggle password visibility">
                                {{-- Eye open --}}
                                <svg x-show="!show" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                {{-- Eye closed --}}
                                <svg x-show="show" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                    <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="meta-row anim anim-d5">
                        <label for="remember_me" class="check-label">
                            <input id="remember_me" type="checkbox" name="remember" class="check-box">
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="anim anim-d6">
                        <button type="submit" class="btn-sign-in">
                            <span class="btn-shimmer"></span>
                            <span class="btn-content">
                                Sign In
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                {{-- Footer --}}
                <div class="form-footer anim anim-d7">
                    <p>&copy; {{ date('Y') }} <span class="school-name">SISC Basic Education</span> &middot; Entrance Examination System</p>
                    <p style="margin-top: 8px; font-size: 11px; color: #b0b8c4; line-height: 1.5;">
                        This system is currently for <strong>capstone project purposes only</strong> until full implementation.
                    </p>
                    <p style="margin-top: 4px; font-size: 11px; color: #b0b8c4; line-height: 1.5;">
                        Created under the guidance of the <strong>SISC CAPS BSED Department</strong><br>at Southville International School and Colleges.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

