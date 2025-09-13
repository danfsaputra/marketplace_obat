<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Toko Alat Kesehatan</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased">
  <header class="bg-white shadow">
    <div class="container mx-auto p-4 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <img src="{{ asset('logo.png') }}" alt="logo" class="w-12 h-12 object-contain">
        <div>
          <h1 class="font-bold">Toko Alat Kesehatan</h1>
          <p class="text-sm text-gray-600">Solusi Alat Kesehatan Online</p>
        </div>
      </div>
      <nav class="flex items-center gap-4">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('cart.index') }}">Keranjang</a>
        @auth
          <span>{{ auth()->user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit">Logout</button></form>
        @else
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Daftar</a>
        @endauth
      </nav>
    </div>
  </header>

  <main class="container mx-auto py-6">
    @if(session('success')) <div class="bg-green-100 p-3 mb-4">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="bg-red-100 p-3 mb-4">{{ session('error') }}</div> @endif

    @yield('content')
  </main>

  <footer class="bg-gray-100 py-6 mt-10">
    <div class="container mx-auto text-center">
      <p>Alamat: Jalan Contoh No.1 — WA: 08xxxxxxxx</p>
    </div>
  </footer>
</body>
</html>
