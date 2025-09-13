@extends('layouts.app')

@section('content')
<h3 class="text-xl">Keranjang Belanja</h3>

@if($items->isEmpty())
  <p>Keranjang kosong.</p>
@else
  <table class="w-full mt-4">
    <thead>
      <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr>
    </thead>
    <tbody>
      @foreach($items as $it)
        <tr>
          <td>{{ $it->product->name }}</td>
          <td>Rp {{ number_format($it->product->price,0,',','.') }}</td>
          <td>
            <form action="{{ route('cart.update') }}" method="POST">
              @csrf
              <input type="hidden" name="id" value="{{ $it->id }}">
              <input type="number" name="quantity" value="{{ $it->quantity }}" min="1" class="w-20">
              <button class="px-2 py-1 bg-gray-200">Update</button>
            </form>
          </td>
          <td>Rp {{ number_format($it->quantity * $it->product->price,0,',','.') }}</td>
          <td>
            <form action="{{ route('cart.remove') }}" method="POST">
              @csrf
              <input type="hidden" name="id" value="{{ $it->id }}">
              <button class="px-2 py-1 bg-red-500 text-white">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">
    <p>Total: Rp {{ number_format($total,0,',','.') }}</p>
    <a href="{{ route('checkout') }}" class="px-4 py-2 bg-green-600 text-white rounded">Checkout</a>
  </div>
@endif
@endsection
