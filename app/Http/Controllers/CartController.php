<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        // INI BAGIAN YANG DIPERBAIKI:
        // Mengambil semua item di keranjang milik pengguna yang sedang login.
        // `with('product')` digunakan untuk mengambil data produk terkait secara efisien.
        $cartItems = CartItem::where('user_id', Auth::id())
                            ->with('product')
                            ->latest()
                            ->get();

        // Mengirim data `$cartItems` ke view 'cart.index'
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $userId = Auth::id();

        // Cek apakah produk sudah ada di keranjang
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan quantity-nya
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat item baru
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui jumlah item di keranjang.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Pastikan pengguna hanya bisa mengubah item miliknya
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);
        
        // Jika kuantitas 0, hapus item. Jika tidak, perbarui.
        if ($request->quantity == 0) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        } else {
            $cartItem->update([
                'quantity' => $request->quantity,
            ]);
            return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
        }
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove(CartItem $cartItem)
    {
        // Pastikan pengguna hanya bisa menghapus item miliknya
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Aksi tidak diizinkan.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}

