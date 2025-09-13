<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function create(){
        return view('shop.request');
    }
    public function store(Request $r){
        $r->validate(['name'=>'required']);
        $shop = Shop::create([
            'user_id'=>auth()->id,
            'name'=>$r->name,
            'slug'=>Str::slug($r->name.'-'.time()),
            'description'=>$r->description,
            'status'=>'pending',
        ]);
        return redirect()->route('home')->with('success','Permintaan pembuatan toko terkirim. Tunggu approval admin.');
    }
}
