<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        // Ganti nama variabel dari $cartItems menjadi $items agar sesuai dengan view
        $items = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Kirim $items ke view
        return view('checkout', compact('items', 'total'));
    }

    /**
     * FUNGSI BARU UNTUK MEMPROSES PESANAN
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada item di keranjang untuk dipesan.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Status 'pending' berarti pesanan menunggu verifikasi admin
            $order = Order::create([
                'user_id' => Auth::id(),
                // INI ADALAH BARIS PERBAIKANNYA
                'order_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                'total_amount' => $totalAmount,
                'status' => 'pending', 
                'shipping_address' => $request->address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // LOGIKA PENGURANGAN STOK DIHAPUS DARI SINI
                // Akan dipindahkan ke proses verifikasi oleh admin
            }

            CartItem::where('user_id', Auth::id())->delete();
            
            DB::commit();

            return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dibuat dan sedang menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Error: ' . $e->getMessage());
        }
    }
}