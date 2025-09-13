<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user){
            $items = CartItem::with('product')->where('user_id',$user->id)->get();
        }else{
            $sid = session()->getId();
            $items = CartItem::with('product')->where('session_id',$sid)->get();
        }
        $total = $items->sum(fn($i)=> $i->quantity * $i->product->price);
        return view('cart.index', compact('items','total'));
    }

    public function add(Request $r){
        $product = Product::findOrFail($r->product_id);
        $qty = max(1, (int)($r->quantity ?? 1));

        if(Auth::check()){
            $item = CartItem::firstOrNew(['user_id'=>Auth::id(),'product_id'=>$product->id]);
        }else{
            $sid = session()->getId();
            $item = CartItem::firstOrNew(['session_id'=>$sid,'product_id'=>$product->id]);
        }
        $item->quantity = ($item->exists ? $item->quantity + $qty : $qty);
        $item->save();

        return back()->with('success','Produk ditambahkan ke keranjang.');
    }

    public function update(Request $r){
        $item = CartItem::findOrFail($r->id);
        $item->quantity = max(1,(int)$r->quantity);
        $item->save();
        return back();
    }

    public function remove(Request $r){
        $item = CartItem::findOrFail($r->id);
        $item->delete();
        return back();
    }
}
