<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Akun - {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Panel (Image) -->
        <div class="hidden lg:flex w-1/2 bg-cover bg-center relative" style="background-image: url('https://placehold.co/1200x1200/334155/e2e8f0?text=Toko\nAlkes');">
            <div class="absolute inset-0 bg-slate-800 bg-opacity-50"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 text-white">
                <h2 class="text-4xl font-bold leading-tight">Toko Alat Kesehatan</h2>
                <p class="mt-4 text-lg text-slate-300">Bergabunglah bersama kami dan penuhi semua kebutuhan kesehatan Anda dengan mudah.</p>
            </div>
        </div>

        <!-- Right Panel (Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                     <a href="/" class="inline-block mb-4">
                        <img src="{{ asset('logo.png') }}" alt="logo" class="w-16 h-16 object-contain" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e2e8f0/e2e8f0?text=Logo';">
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800">Daftar Akun</h2>
                    <p class="text-gray-500 mt-2">Silahkan isi data untuk membuat akun baru.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    
                    <!-- Date of Birth & Gender -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="date_of_birth" value="Tanggal Lahir" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="gender" value="Jenis Kelamin" />
                            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" @if(old('gender') == 'Laki-laki') selected @endif>Laki-laki</option>
                                <option value="Perempuan" @if(old('gender') == 'Perempuan') selected @endif>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Phone & Payment Number -->
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="phone" value="Nomor Telepon" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required placeholder="08123456789" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="payment_number" value="No. Pembayaran (OVO/DANA)" />
                            <x-text-input id="payment_number" class="block mt-1 w-full" type="text" name="payment_number" :value="old('payment_number')" required placeholder="08123456789" />
                            <x-input-error :messages="$errors->get('payment_number')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <x-input-label for="address" value="Alamat Lengkap" />
                        <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Masukkan alamat lengkap Anda">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password"
                                      placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password"
                                      placeholder="Ketik ulang password Anda" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center">
                            Daftar Sekarang
                        </x-primary-button>
                    </div>

                    <div class="text-center mt-6">
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            Sudah punya akun? <span class="font-semibold text-indigo-600">Masuk</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

