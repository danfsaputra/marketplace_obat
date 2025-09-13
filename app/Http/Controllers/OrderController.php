<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Mail\OrderInvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function checkout()
    {
        $items = CartItem::with('product')->where('user_id', Auth::id())->get();
        if($items->isEmpty()) return redirect()->route('cart.index')->with('error','Keranjang kosong');
        $total = $items->sum(fn($i)=> $i->quantity * $i->product->price);
        return view('checkout', compact('items','total'));
    }

    public function place(Request $r)
    {
        $user = Auth::user();
        $user = Auth::user();
        $items = CartItem::with('product')->where('user_id',$user->id)->get();
        if($items->isEmpty()) return back()->with('error','Keranjang kosong');

        $total = $items->sum(fn($i)=> $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id'=>$user->id,
            'order_number'=>'ORD'.time().rand(100,999),
            'total'=>$total,
            'status'=>'pending',
            'address'=>$r->address,
        ]);

        foreach($items as $it){
            OrderItem::create([
                'order_id'=>$order->id,
                'product_id'=>$it->product->id,
                'quantity'=>$it->quantity,
                'price'=>$it->product->price,
            ]);
            // reduce stock
            $it->product->decrement('stock', $it->quantity);
        }

        Payment::create([
            'order_id'=>$order->id,
            'amount'=>$total,
            'method'=>$r->payment_method ?? 'Di Tempat',
            'status'=> $r->payment_method == 'Prepaid' ? 'completed' : 'pending'
        ]);

        CartItem::where('user_id',$user->id)->delete();

        // generate pdf and send email
        $pdf = PDF::loadView('pdf.invoice', compact('order'))->output();
        Mail::to($user->email)->send(new OrderInvoiceMail($order, $pdf));

        return redirect()->route('home')->with('success','Pesanan berhasil dibuat. Invoice dikirim lewat email.');
    }

    public function invoice(Order $order)
    {
        $this->authorize('view', $order);
        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    public function cancel(Request $r, Order $order)
    {
        if($order->status !== 'shipped'){
            $order->update(['status'=>'cancelled']);
            return back()->with('success','Order berhasil dibatalkan.');
        }
        return back()->with('error','Order sudah dikirim tidak bisa dibatalkan.');
    }
}
