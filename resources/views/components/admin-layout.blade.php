<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        /* refined modern design enhancements */
        :root {
            --sidebar-dark: #0f172a;
            --sidebar-darker: #0b1120;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            --transition-smooth: all 0.2s ease-in-out;
        }

        /* custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #5b6e8c;
        }

        body {
            background: #f1f5f9;
            font-family: 'Figtree', sans-serif;
        }

        /* sidebar refined */
        .sidebar-nav a {
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }
        .sidebar-nav a:hover {
            transform: translateX(2px);
        }
        .sidebar-nav a.active {
            background: linear-gradient(95deg, #2563eb 0%, #3b82f6 100%);
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }

        /* main content card style */
        .content-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.6);
            transition: transform 0.1s ease;
        }

        /* header modern */
        .modern-header {
            backdrop-filter: blur(2px);
            background: rgba(255, 255, 255, 0.98);
        }

        /* button & interactive */
        .user-menu-btn {
            transition: all 0.2s;
        }
        .user-menu-btn:hover {
            background-color: #f8fafc;
            transform: scale(0.98);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100">

@php
    $user = Auth::user();

    function navClass($route) {
        return request()->routeIs($route)
            ? 'active bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-md'
            : 'text-gray-300 hover:bg-white/10 hover:text-white';
    }
@endphp

<div class="min-h-screen flex">

    <!-- SIDEBAR - modern dark theme with svg icons -->
    <aside class="w-64 bg-gradient-to-b from-[#0f172a] to-[#0b1120] hidden md:flex flex-col shadow-2xl">

        <!-- Logo Area with refined badge -->
        <div class="h-16 flex items-center justify-between px-5 bg-[#0b1120]/80 border-b border-white/10">
            <div class="flex items-center gap-2">
                <!-- Book SVG icon -->
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h1 class="text-lg font-bold tracking-tight text-white">
                    SiBookStore
                </h1>
            </div>
            <span class="text-[10px] font-semibold bg-blue-600/90 text-white px-2 py-0.5 rounded-full shadow-sm">
                Admin
            </span>
        </div>

        <!-- NAVIGATION with SVG icons -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 text-sm font-medium sidebar-nav">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="{{ navClass('admin.dashboard') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}"
               class="{{ navClass('admin.users.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Pengguna</span>
            </a>


            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="{{ navClass('admin.categories.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span>Kategori</span>
            </a>

            <!-- Books -->
            <a href="{{ route('admin.books.index') }}"
               class="{{ navClass('admin.books.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Data Buku</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}"
               class="{{ navClass('admin.orders.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>Orders</span>
            </a>

            <!-- Payments -->
            <a href="{{ route('admin.payments.index') }}"
               class="{{ navClass('admin.payments.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span>Pembayaran</span>
            </a>
            <a href="{{ route('admin.messages.index') }}"
               class="{{ navClass('admin.messages.*') }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <span>Pesan</span>
            </a>
        </nav>

        <!-- USER Profile section sidebar -->
        <div class="p-4 border-t border-white/10 mt-auto">
            <div class="flex items-center gap-3 bg-white/5 rounded-xl p-2 backdrop-blur-sm">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR - modern glass morphism effect -->
        <header class="modern-header h-16 bg-white/90 backdrop-blur-sm border-b border-gray-200/80 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-3">
                <!-- Mobile menu button (optional for responsive, but hidden on md+) -->
                <div class="md:hidden">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    @yield('page-title', 'Dashboard')
                </h2>
                <!-- subtle breadcrumb decoration -->
                <span class="hidden sm:inline-flex text-xs text-gray-400">/ admin panel</span>
            </div>

            <div class="flex items-center gap-5">
                <!-- Notifications placeholder with SVG -->
                <button class="relative p-1.5 rounded-full text-gray-500 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Profile Dropdown with refined SVG -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-sm font-semibold shadow-sm ring-2 ring-white group-hover:ring-blue-200 transition-all">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT with card style container -->
        <main class="p-6 md:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- wrapping content into refined card background -->
                <div class="content-card p-6 md:p-8 transition-all">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- footer (optional subtle) -->
        <footer class="py-4 text-center text-xs text-gray-400 border-t border-gray-200/50 bg-white/30">
            &copy; {{ date('Y') }} SiBookStore Admin Panel — All rights reserved.
        </footer>
    </div>
</div>

@livewireScripts

<!-- small alpine init fallback if needed -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>