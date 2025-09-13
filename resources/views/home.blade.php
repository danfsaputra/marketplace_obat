@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    {{-- Hero Section --}}
    <div class="mb-8">
        <div class="bg-gray-50 p-6 rounded-lg shadow">
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="md:w-2/3">
                    {{-- Pastikan Anda memiliki gambar hero.jpg di folder public --}}
                    <img src="{{ asset('hero.jpg') }}" alt="Hero Image" class="w-full h-64 object-cover rounded-md" onerror="this.onerror=null;this.src='https://placehold.co/1200x400/e2e8f0/e2e8f0?text=Selamat+Datang';">
                </div>
                <div class="md:w-1/3 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Toko Alat Kesehatan Terpercaya</h2>
                    <p class="mt-2 text-gray-600">Temukan semua kebutuhan kesehatan Anda di sini. Klik produk untuk melihat detail atau hubungi kami via WhatsApp.</p>
                    {{-- Ganti nomor WhatsApp dengan nomor Anda --}}
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-colors">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Section --}}
    <div>
        <h3 class="text-2xl font-bold mb-4 text-gray-800">Produk Kami</h3>
        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $p)
                    <div class="border rounded-lg overflow-hidden shadow-lg flex flex-col hover:shadow-xl transition-shadow">
                        <a href="{{ route('products.show', $p) }}">
                            {{-- INI ADALAH BAGIAN YANG DIPERBAIKI --}}
                            <img src="{{ asset('storage/' . $p->image) }}" 
                                 alt="{{ $p->name }}" 
                                 class="w-full h-48 object-cover"
                                 onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image';">
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <h4 class="font-semibold text-lg">{{ $p->name }}</h4>
                            <p class="text-gray-600 mb-3">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                            
                            <div class="mt-auto flex gap-2">
                                <a href="{{ route('products.show', $p) }}" class="flex-1 text-center px-3 py-2 border rounded hover:bg-gray-100">View</a>
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" class="w-full px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-gray-500">Belum ada produk yang tersedia saat ini.</p>
        @endif
    </div>
</div>
@endsection