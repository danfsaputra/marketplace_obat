<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan produk dalam kategori tertentu.
     */
    public function show(Category $category, Request $request)
    {
        // Memulai query untuk produk dalam kategori ini
        $productQuery = $category->products();

        // Filter berdasarkan pencarian jika ada
        if ($request->filled('search')) {
            $productQuery->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil produk dengan paginasi
        $products = $productQuery->latest()->paginate(8)->appends($request->query());
        
        return view('products.index', compact('products', 'category'));
    }
}