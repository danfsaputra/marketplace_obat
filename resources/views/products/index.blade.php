@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb and Title -->
    <div class="mb-6">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li>
                    <span class="text-gray-700 font-bold">{{ $category->name }}</span>
                </li>
            </ol>
        </nav>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">Produk dalam Kategori: {{ $category->name }}</h2>
    </div>

    <!-- Product Grid -->
    @if(isset($products) && $products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $p)
                <div class="bg-white border rounded-lg overflow-hidden shadow-sm flex flex-col hover:shadow-xl transition-shadow">
                    <a href="{{ route('products.show', $p) }}">
                        <img src="{{ asset('storage/' . $p->image) }}"
                             alt="{{ $p->name }}"
                             class="w-full h-48 object-cover"
                             onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image';">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="font-semibold text-lg text-gray-800">{{ $p->name }}</h4>
                        <p class="text-gray-600 mb-3">Rp {{ number_format($p->price, 0, ',', '.') }}</p>

                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('products.show', $p) }}" class="flex-1 text-center px-3 py-2 border rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <button type="submit" class="w-full px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium transition-colors">
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-xl font-semibold">Belum ada produk di kategori ini.</p>
            <p class="text-gray-400 mt-2">Silakan kembali untuk melihat kategori lainnya.</p>
             <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                 Kembali ke Kategori
             </a>
        </div>
    @endif
</div>
@endsection