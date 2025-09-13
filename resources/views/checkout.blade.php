@extends('layouts.app')

@section('content')
<h3>Checkout</h3>

<form action="{{ route('order.place') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label>Alamat Pengiriman</label>
    <textarea name="address" required class="w-full border p-2">{{ auth()->user()->address ?? '' }}</textarea>
  </div>
  <div class="mb-3">
    <label>Metode Pembayaran</label>
    <select name="payment_method" class="w-full border p-2">
      <option value="Prepaid">Prepaid (Debit/Credit/PayPal)</option>
      <option value="Di Tempat">Bayar di Tempat</option>
    </select>
  </div>

  <div class="mb-3">
    <h4>Ringkasan</h4>
    <ul>
      @foreach($items as $it)
        <li>{{ $it->product->name }} x {{ $it->quantity }} - Rp {{ number_format($it->product->price * $it->quantity,0,',','.') }}</li>
      @endforeach
    </ul>
    <p>Total: Rp {{ number_format($total,0,',','.') }}</p>
  </div>

  <button class="px-4 py-2 bg-blue-600 text-white rounded">Place Order</button>
</form>
@endsection
