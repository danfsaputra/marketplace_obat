<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman ringkasan checkout.
     */
    public function showCheckoutPage()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Tidak bisa melanjutkan ke checkout.');
        }
        
        // Menghitung total untuk ditampilkan di halaman checkout
        $totalAmount = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout', compact('cartItems', 'totalAmount'));
    }

    /**
     * Memproses pesanan dari halaman checkout.
     */
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        // Gunakan DB Transaction untuk memastikan semua operasi berhasil
        DB::transaction(function () use ($user, $cartItems) {
            // Hitung total harga
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // 1. Buat pesanan baru
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending', // Status awal pesanan
            ]);

            // 2. Pindahkan item dari keranjang ke item pesanan
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // 3. Kosongkan keranjang pengguna
            CartItem::where('user_id', $user->id)->delete();
        });

        return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
