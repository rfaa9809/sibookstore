<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

            <footer class="mt-16 text-gray-400 bg-gray-900">
                <div class="grid gap-6 px-4 py-10 mx-auto max-w-7xl md:grid-cols-4">

                    <div>
                        <h3 class="mb-2 font-bold text-white">SiBookStore</h3>
                        <p class="text-sm">Platform jual beli buku online modern.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 text-white">Menu</h4>
                        <ul class="space-y-1 text-sm">
                            <li><a href="#h">Home</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 text-white">Kontak</h4>
                        <p class="text-sm">admin@sibookstore.com</p>
                    </div>

                    <div>
                        <h4 class="mb-2 text-white">Follow</h4>
                        <p class="text-sm">Instagram: @sibookstore</p>
                    </div>

                </div>

                <div class="py-4 text-xs text-center border-t border-gray-800">
                    © {{ date('Y') }} SiBookStore
                </div>
            </footer>

        @livewireScripts
    </body>
</html>
