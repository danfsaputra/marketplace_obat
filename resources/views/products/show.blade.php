@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
  <div>
    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('placeholder.png') }}" class="w-full h-96 object-cover" alt="">
  </div>
  <div class="col-span-2">
    <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
    <p class="mt-2">Kategori: {{ $product->category?->name ?? '-' }}</p>
    <p class="mt-4">{!! nl2br(e($product->description)) !!}</p>
    <p class="mt-4 font-semibold">Rp {{ number_format($product->price,0,',','.') }}</p>
    <p class="mt-2 text-sm">Stok: {{ $product->stock }}</p>

    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border p-1 w-20 inline">
      <button class="px-4 py-2 bg-blue-600 text-white rounded">Tambah ke Keranjang</button>
    </form>

    <div class="mt-6">
      <h4>Ulasan</h4>
      @foreach($reviews as $r)
        <div class="border p-2 mt-2">
          <strong>{{ $r->user?->name ?? 'Guest' }}</strong>
          <p>{{ $r->comment }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
