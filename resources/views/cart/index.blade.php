@extends('layouts.app')

@section('content')
<div x-data="cart()" x-init="
    items = {{ json_encode($cartItems->map(function($item) {
        return [
            'id' => $item->id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
            'checked' => true
        ];
    })) }};
    updateTotals();
">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 lg:items-start">
                <!-- Left column: Cart items -->
                <section class="lg:col-span-8">
                    <div class="bg-white shadow rounded-lg p-4 mb-4 flex justify-between items-center">
                        <div>
                            <input type="checkbox" id="select-all" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @click="toggleSelectAll($event)" :checked="isAllSelected()">
                            <label for="select-all" class="ml-3 text-sm font-medium text-gray-700">Pilih Semua</label>
                        </div>
                        <button @click="removeSelected" class="text-sm font-medium text-red-600 hover:text-red-800 disabled:text-gray-400" :disabled="!canRemoveSelected()">Hapus</button>
                    </div>

                    <ul role="list" class="space-y-4">
                        @foreach($cartItems as $index => $item)
                        <li class="bg-white shadow rounded-lg p-4 flex items-start">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mt-1" x-model="items[{{ $index }}].checked" @change="updateTotals">

                            <div class="ml-4 flex-1 flex flex-col sm:flex-row sm:justify-between">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-md" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e2e8f0/e2e8f0?text=Img';">
                                    <div class="ml-4">
                                        <h3 class="text-base font-medium text-gray-900">
                                            <a href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a>
                                        </h3>
                                        <p class="mt-1 text-lg font-bold text-gray-800">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 sm:mt-0 flex items-center justify-between sm:justify-end sm:flex-col sm:items-end space-y-2">
                                    <div class="flex items-center border border-gray-200 rounded">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="contents">
                                            @csrf
                                            <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                            <button type="submit" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-l {{ $item->quantity <= 1 ? 'cursor-not-allowed text-gray-300' : '' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                        </form>
                                        <span class="px-4 py-1 text-center" x-text="items[{{ $index }}].quantity">{{ $item->quantity }}</span>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="contents">
                                            @csrf
                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                            <button type="submit" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-r">+</button>
                                        </form>
                                    </div>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-gray-400 hover:text-red-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </section>

                <!-- Right column: Order summary -->
                <section class="lg:col-span-4 mt-8 lg:mt-0">
                    <div class="bg-white shadow rounded-lg p-6 sticky top-24">
                        <h2 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900" x-text="formatCurrency(subtotal)"></dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-sm text-gray-600">Ongkos Kirim</dt>
                                <dd class="text-sm font-medium text-gray-900">Gratis</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Total Pesanan</dt>
                                <dd class="text-base font-medium text-gray-900" x-text="formatCurrency(total)"></dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            {{-- PERUBAHAN DI SINI: Menggunakan nama rute yang benar --}}
                            <a href="{{ route('checkout.show') }}" class="w-full block text-center bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Keranjang Anda kosong.</h2>
                <p class="text-gray-500 mt-2">Sepertinya Anda belum menambahkan produk apa pun.</p>
                <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    function cart() {
        return {
            items: [],
            subtotal: 0,
            total: 0,
            shipping: 0, // Bisa diubah jika ada logika ongkir

            updateTotals() {
                let currentSubtotal = 0;
                this.items.forEach(item => {
                    if (item.checked) {
                        currentSubtotal += item.price * item.quantity;
                    }
                });
                this.subtotal = currentSubtotal;
                this.total = this.subtotal + this.shipping;
            },

            formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            },
            
            toggleSelectAll(event) {
                let checked = event.target.checked;
                this.items.forEach(item => item.checked = checked);
                this.updateTotals();
            },

            isAllSelected() {
                return this.items.length > 0 && this.items.every(item => item.checked);
            },
            
            canRemoveSelected() {
                 return this.items.some(item => item.checked);
            },

            // Fungsi ini belum diimplementasikan karena butuh perubahan backend
            removeSelected() {
                alert('Fungsi hapus item terpilih belum diimplementasikan di backend.');
            }
        }
    }
</script>
@endsection

