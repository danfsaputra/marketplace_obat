<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style> body { font-family: DejaVu Sans, sans-serif; } table { width:100%; border-collapse: collapse;} td, th { border:1px solid #ddd; padding:6px; } </style>
</head>
<body>
  <h2>Toko Alat Kesehatan</h2>
  <p>Invoice: {{ $order->order_number }}</p>
  <p>Nama: {{ $order->user->name }} <br> Email: {{ $order->user->email }}</p>
  <table>
    <thead><tr><th>No</th><th>Produk</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr></thead>
    <tbody>
      @foreach($order->items as $i)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $i->product->name }}</td>
          <td>{{ $i->quantity }}</td>
          <td>Rp {{ number_format($i->price,0,',','.') }}</td>
          <td>Rp {{ number_format($i->price * $i->quantity,0,',','.') }}</td>
        </tr>
      @endforeach
      <tr><td colspan="4" style="text-align:right"><strong>Total</strong></td><td>Rp {{ number_format($order->total,0,',','.') }}</td></tr>
    </tbody>
  </table>
  <p style="margin-top:30px">Tanda tangan toko: ____________________</p>
</body>
</html>
