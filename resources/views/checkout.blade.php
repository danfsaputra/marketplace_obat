@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

    {{-- Form utama yang membungkus semua bagian --}}
    <form action="{{ route('order.place') }}" method="POST">
        @csrf
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 lg:items-start">
            <!-- Left column: Shipping and Order Details -->
            <section class="lg:col-span-8 space-y-6">

                <!-- Order Details -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b pb-4">Detail Pesanan</h2>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e2e8f0/e2e8f0?text=Img';">
                                <div class="ml-4">
                                    <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-gray-800">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </section>

            <!-- Right column: Order Summary and Payment -->
            <section class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="bg-white shadow rounded-lg p-6 sticky top-24 space-y-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Ringkasan Belanja</h2>
                        <dl class="mt-4 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($totalAmount, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Ongkos Kirim</dt>
                                <dd class="text-sm font-medium text-gray-900">Gratis</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Total Pembayaran</dt>
                                <dd class="text-base font-bold text-gray-900">Rp {{ number_format($totalAmount, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h2 class="text-lg font-medium text-gray-900 border-t pt-6">Pilih Pembayaran</h2>
                        <div class="mt-4 space-y-4">
                             <div class="flex items-center">
                                <input id="bca" name="payment_method" type="radio" value="bca_manual" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" checked>
                                <label for="bca" class="ml-3 block text-sm font-medium text-gray-700"> Bank Transfer </label>
                            </div>
                             <div class="flex items-center">
                                <input id="cod" name="payment_method" type="radio" value="cod" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="cod" class="ml-3 block text-sm font-medium text-gray-700"> COD (Bayar di Tempat) </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
@endsection

