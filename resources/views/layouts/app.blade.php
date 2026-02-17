<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Favicon --}}
        <link rel="icon" type="image/x-icon" href="{{ $systemLogo ?? asset('favicon.ico') }}">

        <title>{{ config('app.name', 'CAPSAT') }}</title>

        <!-- Fonts -->
        <link href="https://api.fontshare.com/v2/css?f[]=satoshi@400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            /* ── Global Transitions ───────────────────── */
            * { transition: background-color 0.2s ease, border-color 0.2s ease; }

            /* ── Global Mobile Responsive & Zoom-Robust ── */
            :root {
                --sidebar-width: 260px;
                --sidebar-collapsed-width: 68px;
            }

            @media (max-width: 1024px) {
                /* Trigger mobile-like behavior earlier for better zoom support */
                .py-12 { padding-top: 2rem !important; padding-bottom: 2rem !important; }
                .px-6, .lg\:px-8 { padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
            }

            @media (max-width: 768px) {
                .py-12 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
                .p-6 { padding: 1.25rem !important; }
                .px-6, .lg\:px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
                .p-8 { padding: 1.5rem !important; }
                
                /* Tables → horizontal scroll */
                .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
                
                /* Dashboard welcome: stack */
                .rounded-lg h1 { font-size: 1.75rem !important; }

                /* Stats/Grids */
                .grid-cols-1.sm\:grid-cols-2.lg\:grid-cols-5 { grid-template-columns: repeat(2, 1fr) !important; }
            }

            @media (max-width: 480px) {
                .grid-cols-1, .sm\:grid-cols-2 { grid-template-columns: 1fr !important; }
                .p-4, .p-5 { padding: 1rem !important; }
            }

            /* Sidebar Management */
            .sidebar {
                width: var(--sidebar-width);
                min-height: 100vh;
                background: var(--sisc-purple, #2E1065);
                border-right: 1px solid rgba(255, 255, 255, 0.1);
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 40;
            }

            .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
            
            .main-content {
                margin-left: var(--sidebar-width);
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                width: calc(100% - var(--sidebar-width));
            }

            .sidebar.collapsed ~ .main-content,
            .main-content.expanded { 
                margin-left: var(--sidebar-collapsed-width); 
                width: calc(100% - var(--sidebar-collapsed-width));
            }

            /* Brand & Nav items */
            .brand-logo {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 24px 20px;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }

            .sidebar.collapsed .nav-text,
            .sidebar.collapsed .brand-text,
            .sidebar.collapsed .profile-info,
            .sidebar.collapsed .section-label { 
                opacity: 0;
                visibility: hidden;
                width: 0;
                display: none; 
            }

            /* Zoom & Extreme Resolution Protection */
            @media (min-width: 1921px) {
                /* Keep readability on ultra-wide */
                .max-w-prose { max-width: 85ch; }
            }

            /* ── Core Visual Components (Restored) ───── */
            .brand-icon {
                width: 36px;
                height: 36px;
                min-width: 36px;
                background: var(--sisc-gold, #F59E0B);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .brand-text h2 { font-size: 15px; font-weight: 700; color: #ffffff; line-height: 1.2; }
            .brand-text p { font-size: 11px; color: #E9D5FF; }

            .nav-section { padding: 16px 12px 8px; flex: 1; overflow-y: auto; }
            .section-label {
                font-size: 11px;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.6);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 0 8px 8px;
            }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 12px;
                margin-bottom: 2px;
                border-radius: 8px;
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.15s ease;
            }

            .nav-item:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
            .nav-item.active { background: rgba(255, 255, 255, 0.15); color: var(--sisc-gold, #F59E0B); font-weight: 600; }
            .nav-icon { width: 20px; height: 20px; min-width: 20px; opacity: 0.8; }
            .nav-item.active .nav-icon { opacity: 1; color: var(--sisc-gold, #F59E0B); }

            .profile-block { padding: 16px; border-top: 1px solid rgba(255, 255, 255, 0.1); display: flex; align-items: center; gap: 10px; }
            .profile-avatar {
                width: 36px; height: 36px; min-width: 36px; border-radius: 50%;
                background: var(--sisc-gold, #F59E0B); color: var(--sisc-purple, #2E1065); display: flex; align-items: center; justify-content: center;
                font-size: 14px; font-weight: 700;
            }

            .profile-info { flex: 1; min-width: 0; }
            .profile-info p { font-size: 13px; font-weight: 600; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .profile-info span { font-size: 11px; color: rgba(255, 255, 255, 0.6); }

            .collapse-btn {
                width: 28px; height: 28px; min-width: 28px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2);
                background: var(--sisc-purple, #2E1065); color: rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center;
                cursor: pointer; transition: all 0.15s ease; position: absolute; top: 22px; right: -14px; z-index: 50;
            }
            .collapse-btn:hover { background: var(--sisc-purple, #2E1065); filter: brightness(1.2); color: #ffffff; }

            .topbar {
                display: none; background: var(--sisc-purple, #2E1065); padding: 12px 16px; align-items: center;
                justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.1); position: sticky; top: 0; z-index: 30;
            }
            .topbar-burger { background: none; border: none; color: #ffffff; cursor: pointer; padding: 4px; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 35; }

            @media (max-width: 768px) {
                .sidebar { transform: translateX(-100%); width: 260px !important; }
                .sidebar.mobile-open { transform: translateX(0); }
                .sidebar-overlay.show { display: block; }
                .main-content { margin-left: 0 !important; width: 100% !important; }
                .topbar { display: flex; }
                .collapse-btn { display: none; }
                .sidebar.collapsed .nav-text,
                .sidebar.collapsed .brand-text,
                .sidebar.collapsed .profile-info,
                .sidebar.collapsed .section-label { display: block; opacity: 1; visibility: visible; width: auto; }
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 bg-sisc-pattern" x-data="{
    sidebarCollapsed: {{ $sidebarCollapsed ? 'true' : 'false' }},
    mobileOpen: false,
    userDropdownOpen: false
}">

    <!-- Impersonation Banner -->
    @if(session('impersonator_id'))
        <div class="bg-red-600 text-white px-4 py-2 text-center text-sm font-bold shadow-md relative z-50">
            You are currently logged in as {{ Auth::user()->name }}.
            <form action="{{ route('impersonate.leave') }}" method="POST" class="inline ml-4">
                @csrf
                <button type="submit" class="underline hover:text-red-100 uppercase tracking-wider text-xs bg-white/20 px-3 py-1 rounded">Logged in as Admin</button>
            </form>
        </div>
    @endif

    <div class="min-h-screen flex flex-col md:flex-row">
        {{-- Mobile overlay --}}
        <div class="sidebar-overlay" :class="{ 'show': mobileOpen }" @click="mobileOpen = false"></div>

        {{-- ═══ SIDEBAR ═══ --}}
        <aside class="sidebar" :class="{ 'collapsed': sidebarCollapsed, 'mobile-open': mobileOpen }">

            {{-- Collapse button (desktop) --}}
            <button class="collapse-btn" @click="sidebarCollapsed = !sidebarCollapsed" title="Toggle sidebar">
                <svg x-show="!sidebarCollapsed" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                <svg x-show="sidebarCollapsed" x-cloak width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </button>

            {{-- Brand --}}
            <div class="brand-logo">
                <div class="brand-icon" style="background: none; box-shadow: none;">
                    @if($systemLogo)
                        <img src="{{ $systemLogo }}" alt="Logo" class="w-12 h-12 object-contain">
                    @else
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="brand-text">
                    <h2>{{ $systemName }}</h2>
                    <p>{{ $systemTitle }}</p>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="nav-section">
                <div class="section-label">Menu</div>

                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard</span>
                </a>

                {{-- Psychometrician --}}
                @if(Auth::user()->hasRole('psychometrician'))
                    <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="nav-text">Students</span>
                    </a>
                    <a href="{{ route('exams.index') }}" class="nav-item {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span class="nav-text">Exams</span>
                    </a>
                    <a href="{{ route('norms.index') }}" class="nav-item {{ request()->routeIs('norms.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span class="nav-text">Norm Tables</span>
                    </a>
                    <a href="{{ route('results.index') }}" class="nav-item {{ request()->routeIs('results.index') || request()->routeIs('results.show') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span class="nav-text">Results</span>
                    </a>
                    <a href="{{ route('results.retakes.index') }}" class="nav-item {{ request()->routeIs('results.retakes.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                        <span class="nav-text">Retake Requests</span>
                    </a>
                @endif

                {{-- Student --}}
                @if(Auth::user()->hasRole('student'))
                    <a href="{{ route('my-profile.edit') }}" class="nav-item {{ request()->routeIs('my-profile.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="nav-text">My Profile</span>
                    </a>
                    <a href="{{ route('student.exams.index') }}" class="nav-item {{ request()->routeIs('student.exams.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        <span class="nav-text">My Exams</span>
                    </a>
                @endif

                {{-- Counselor --}}
                @if(Auth::user()->hasRole('counselor'))
                    <a href="{{ route('counselor.index') }}" class="nav-item {{ request()->routeIs('counselor.index') || request()->routeIs('counselor.show') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span class="nav-text">Pending Reviews</span>
                    </a>
                    <a href="{{ route('counselor.history') }}" class="nav-item {{ request()->routeIs('counselor.history') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 3"></path><path d="M3.05 11a9 9 0 1 1 .5 4"></path><polyline points="1 4 3.05 11 10 8.5"></polyline></svg>
                        <span class="nav-text">Review History</span>
                    </a>
                @endif

                {{-- Admin --}}
                @if(Auth::user()->hasRole('admin'))
                    <div class="section-label" style="margin-top: 16px;">Administration</div>
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="nav-text">Users</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="nav-text">Settings</span>
                    </a>
                    <a href="{{ route('admin.audit.index') }}" class="nav-item {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span class="nav-text">Audit Logs</span>
                    </a>
                    <a href="{{ route('admin.backup.index') }}" class="nav-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="nav-text">Database Backups</span>
                    </a>
                @endif
            </div>

            {{-- Profile + Logout --}}
            <div style="border-top: 1px solid #334155;">
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" style="margin: 8px 12px 4px;">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span class="nav-text">Profile Settings</span>
                </a>
                <div class="profile-block">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <p>{{ Auth::user()->name }}</p>
                        <span>{{ ucfirst(Auth::user()->role->name ?? 'User') }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" title="Log out" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 6px; border-radius: 6px; transition: all 0.15s;" onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.color='#64748b';this.style.background='none'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ═══ MAIN ═══ --}}
        <div class="main-content" :class="{ 'expanded': sidebarCollapsed }">

            {{-- Mobile top bar --}}
            <div class="topbar">
                <button class="topbar-burger" @click="mobileOpen = !mobileOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div class="brand-icon" style="width: 32px; height: 32px; min-width: 32px; background: none; box-shadow: none;">
                        @if($systemLogo)
                            <img src="{{ $systemLogo }}" alt="Logo" class="w-full h-full object-contain">
                        @else
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        @endif
                    </div>
                    <span style="color: #e2e8f0; font-weight: 600; font-size: 14px;">{{ $systemName }}</span>
                </div>
                <div style="width: 24px;"></div>
            </div>

            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="py-5 px-6 lg:px-8 flex justify-between items-center">
                        <div class="flex-1">
                            {{ $header }}
                        </div>

                        <!-- Notification Bell -->
                        <div x-data="{ open: false }" class="relative ml-4">
                            <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-sisc-gold transition-colors rounded-full" style="--hover-bg: color-mix(in srgb, var(--sisc-purple), transparent 90%);" onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" onmouseout="this.style.backgroundColor='transparent'">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-1.5 right-1.5 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                                @endif
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 rounded shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-50 overflow-hidden"
                                 style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                    <h3 class="text-sm font-bold text-gray-700">Notifications</h3>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-sisc-purple transition-colors" style="--hover-color: color-mix(in srgb, var(--sisc-purple), black 20%);" onmouseover="this.style.color=this.style.getPropertyValue('--hover-color')" onmouseout="this.style.color=''">Mark all read</button>
                                        </form>
                                    @endif
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 transition-colors border-b border-gray-50 last:border-0 relative group" style="--hover-bg: color-mix(in srgb, var(--sisc-purple), transparent 95%);" onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg')" onmouseout="this.style.backgroundColor=''">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    @php
                                                        $iconValues = [
                                                            'success' => ['bg-emerald-100', 'text-emerald-600', 'M5 13l4 4L19 7'],
                                                            'warning' => ['bg-amber-100', 'text-amber-600', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                                            'info' => ['bg-blue-100', 'text-blue-600', 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                            'error' => ['bg-red-100', 'text-red-600', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                                                        ];
                                                        $type = $notification->data['type'] ?? 'info';
                                                        $style = $iconValues[$type] ?? $iconValues['info'];
                                                    @endphp
                                                    <div class="{{ $style[0] }} rounded-full p-1.5">
                                                        <svg class="h-4 w-4 {{ $style[1] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style[2] }}"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900 group-hover:text-sisc-purple transition-colors">{{ $notification->data['message'] }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-gray-500">
                                            <p class="text-sm">No new notifications</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
    {{ $slot }}
</main>


        </div>

    </body>
</html>

