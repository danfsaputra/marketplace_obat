<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('category','shop')->findOrFail($id);
        $reviews = Review::where('product_id',$product->id)->latest()->get();
        return view('products.show', compact('product','reviews'));
    }
}
