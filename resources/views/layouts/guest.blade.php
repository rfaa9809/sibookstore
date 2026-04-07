<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BookStore' }} - SiBookStore</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b shadow-sm">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-xl font-bold text-blue-600">SiBookStore</span>
                </a>

                <!-- Menu -->
                <div class="items-center hidden gap-6 text-sm font-medium md:flex">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-blue-600">About</a>
                    <a href="{{ route('contact') }}" class="hover:text-blue-600">Contact</a>

                    @auth
                        <a href="{{ route('cart.index') }}" class="hover:text-blue-600">
                            Cart
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-red-500">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Right -->
                <div class="flex items-center gap-3">

                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative">
                            🛒
                        </a>

                        <!-- User -->
                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center w-8 h-8 text-sm text-white bg-blue-600 rounded-full">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <!-- Dropdown -->
                            <div class="relative group">
                                <button class="text-sm">
                                    {{ auth()->user()->name }}
                                </button>

                                <div class="absolute right-0 hidden w-40 mt-2 bg-white border rounded-lg shadow group-hover:block">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                        Profile
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="text-sm">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">
                            Register
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="mt-16 text-gray-400 bg-gray-900">
        <div class="grid gap-6 px-4 py-10 mx-auto max-w-7xl md:grid-cols-4">

            <div>
                <h3 class="mb-2 font-bold text-white">SiBookStore</h3>
                <p class="text-sm">Platform jual beli buku online modern.</p>
            </div>

            <div>
                <h4 class="mb-2 text-white">Menu</h4>
                <ul class="space-y-1 text-sm">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-2 text-white">Kontak</h4>
                <p class="text-sm">admin@sibookstore.com</p>
            </div>

            <div>
                <h4 class="mb-2 text-white">Follow</h4>
                <p class="text-sm">Social media here</p>
            </div>

        </div>

        <div class="py-4 text-xs text-center border-t border-gray-800">
            © {{ date('Y') }} SiBookStore
        </div>
    </footer>

    @livewireScripts
</body>
</html>