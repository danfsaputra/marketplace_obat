@extends('layouts.app')

@section('content')
<div class="mb-6">
  <div class="bg-gray-50 p-6 rounded">
    <div class="flex gap-6">
      <div class="w-2/3">
        <img src="{{ asset('hero.jpg') }}" alt="hero" class="w-full h-56 object-cover rounded">
      </div>
      <div>
        <h2 class="text-2xl font-bold">Selamat datang di Toko Alat Kesehatan</h2>
        <p class="mt-2">Deskripsi singkat toko. Klik produk untuk melihat detail atau tekan Pesan Sekarang untuk menghubungi via WhatsApp.</p>
        <a href="https://wa.me/628xxxxxxxx" target="_blank" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded">Pesan Sekarang</a>
      </div>
    </div>
  </div>
</div>

<div>
  <h3 class="text-xl mb-3">Produk</h3>
  <div class="grid grid-cols-3 gap-6">
    @foreach($products as $p)
      <div class="border p-4 rounded">
        <img src="{{ $p->image ? asset('storage/'.$p->image) : asset('placeholder.png') }}" class="w-full h-40 object-cover mb-3" alt="">
        <h4 class="font-semibold">{{ $p->name }}</h4>
        <p class="text-sm">Rp {{ number_format($p->price,0,',','.') }}</p>
        <div class="mt-3 flex gap-2">
          <a href="{{ route('product.show',$p->id) }}" class="px-3 py-1 border rounded">View</a>
          <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $p->id }}">
            <button class="px-3 py-1 bg-blue-600 text-white rounded">Buy</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-6">
    {{ $products->links() }}
  </div>
</div>
@endsection
