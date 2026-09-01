@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-sm mt-8">
    <div class="flex justify-between border-b pb-4 mb-4"><div><h1 class="text-xl font-bold">Struk Transaksi</h1><p>{{ $transaksi->kode_transaksi }}</p></div><div class="text-right"><p>{{ $transaksi->created_at->format('d/m/Y H:i') }}</p><p>{{ $transaksi->gudang->nama_gudang }}</p></div></div>
    @foreach($transaksi->detail as $detail)<div class="flex justify-between py-2"><span>{{ $detail->produk->nama_produk }} x {{ $detail->qty }}</span><span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span></div>@endforeach
    <div class="border-t mt-3 pt-3 space-y-1 text-right"><p>Total: <strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></p><p>Bayar: Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p><p>Kembalian: Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p></div>
    <a href="{{ route('kasir.index') }}" class="inline-block mt-6 bg-slate-800 text-white px-4 py-2">Transaksi Baru</a>
</div>
@endsection
