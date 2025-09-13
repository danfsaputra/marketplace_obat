<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <header x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & System Name -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="logo" class="w-10 h-10 object-contain" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e2e8f0/e2e8f0?text=Logo';">
                        <div>
                            <h1 class="font-bold text-gray-800">Toko Alat Kesehatan</h1>
                            <p class="hidden sm:block text-xs text-gray-500">Solusi Alat Kesehatan Online</p>
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 justify-center px-6">
                    <form action="{{ route('home') }}" method="GET" class="w-full max-w-lg">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari produk..." type="search" name="search" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>

                <!-- Right Navigation -->
                <nav class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="hidden sm:block text-sm font-medium text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('cart.index') }}" class="p-2 text-gray-500 hover:text-gray-800">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                            @auth
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-semibold text-gray-700 truncate">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Akun</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Daftar</a>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
             <!-- Search Bar for Mobile -->
            <div class="md:hidden mt-2 pb-4">
                <form action="{{ route('home') }}" method="GET" class="w-full">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari produk..." type="search" name="search" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
    </header>

    <main class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white py-6 mt-10 border-t">
        <div class="container mx-auto text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Toko Alat Kesehatan. All Rights Reserved.</p>
            <p class="text-sm mt-1">Alamat: Jalan Contoh No.123, Jakarta — WA: 0812-3456-7890</p>
        </div>
    </footer>
</body>
</html>
