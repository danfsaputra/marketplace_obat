@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    {{-- Hero Section --}}
    <div class="mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="md:w-2/3">
                    <img src="{{ asset('hero.jpg') }}" alt="Hero Image" class="w-full h-64 object-cover rounded-md" onerror="this.onerror=null;this.src='https://placehold.co/1200x400/e2e8f0/e2e8f0?text=Selamat+Datang';">
                </div>
                <div class="md:w-1/3 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Toko Alat Kesehatan Terpercaya</h2>
                    <p class="mt-2 text-gray-600">Jelajahi kategori produk kami untuk menemukan solusi kesehatan terbaik bagi Anda.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-colors">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Section --}}
    <div>
        <h3 class="text-2xl font-bold mb-4 text-gray-800">Pilih Kategori Produk</h3>
        @if(isset($categories) && $categories->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="block p-4 bg-white rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all text-center">
                        <div class="flex justify-center items-center h-24 mb-3">
                            {{-- Anda bisa menambahkan gambar untuk setiap kategori jika ada --}}
                            <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2zM7 13h.01M17 13h.01M17 17h.01M17 21h-5a2 2 0 01-2-2v-5a2 2 0 012-2h5a2 2 0 012 2v5a2 2 0 01-2 2zM17 3h-5a2 2 0 00-2 2v5a2 2 0 002 2h5a2 2 0 002-2V5a2 2 0 00-2-2z"></path></svg>
                        </div>
                        <h4 class="font-semibold text-gray-700">{{ $category->name }}</h4>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">Belum ada kategori yang tersedia.</p>
        @endif
    </div>
</div>
@endsection