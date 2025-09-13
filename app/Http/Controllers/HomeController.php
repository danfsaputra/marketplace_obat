<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(9);
        $categories = Category::all();
        return view('home', compact('products','categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        $products = $category->products()->paginate(9);
        $categories = Category::all();
        return view('home', compact('products','categories','category'));
    }
}
