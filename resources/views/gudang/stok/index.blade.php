@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6"><div class="flex justify-between items-center mb-5"><h1 class="text-2xl font-bold">Stok Gudang</h1><a href="{{ route('stok.menipis') }}" class="text-red-600">Lihat stok menipis</a></div>@include('components.flash')
<form method="POST" action="{{ route('stok.restock') }}" class="bg-white p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">@csrf<select name="produk_id" class="border p-2" required><option value="">Produk</option>@foreach(\App\Models\Produk::orderBy('nama_produk')->get() as $produk)<option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>@endforeach</select><select name="gudang_id" class="border p-2" required><option value="">Gudang</option>@foreach(\App\Models\Gudang::orderBy('nama_gudang')->get() as $gudang)<option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }}</option>@endforeach</select><input type="number" name="qty" min="1" class="border p-2" placeholder="Jumlah" required><button class="bg-blue-600 text-white px-4 py-2">Restock</button></form>
<div class="bg-white shadow-sm overflow-x-auto">
<table class="w-full text-left"><thead class="bg-slate-100"><tr><th class="p-3">Produk</th><th class="p-3">Gudang</th><th class="p-3">Stok</th><th class="p-3">Minimum</th></tr></thead><tbody>@forelse($stoks as $stok)<tr class="border-t"><td class="p-3">{{ $stok->produk->nama_produk }}</td><td class="p-3">{{ $stok->gudang->nama_gudang }}</td><td class="p-3">{{ $stok->jumlah_stok }}</td><td class="p-3">{{ $stok->stok_minimum }}</td></tr>@empty<tr><td colspan="4" class="p-6 text-center">Belum ada data stok.</td></tr>@endforelse</tbody></table></div></div>
@endsection

@push('scripts')
<script>
let keranjang = [];

document.querySelectorAll('.produk-card').forEach(card => {
    card.addEventListener('click', () => {
        const id = card.dataset.id;
        const nama = card.dataset.nama;
        const harga = parseFloat(card.dataset.harga);
        const stok = parseInt(card.dataset.stok);

        let item = keranjang.find(i => i.id === id);
        if (item) {
            if (item.qty < stok) item.qty++;
        } else {
            if (stok > 0) keranjang.push({ id, nama, harga, qty: 1 });
        }
        renderKeranjang();
    });
});

function renderKeranjang() {
    const tbody = document.querySelector('#tabel-keranjang tbody');
    const inputItems = document.getElementById('input-items');
    tbody.innerHTML = '';
    inputItems.innerHTML = '';
    let total = 0;

    keranjang.forEach((item, i) => {
        total += item.harga * item.qty;
        tbody.innerHTML += `<tr>
            <td>${item.nama}</td>
            <td>${item.qty}</td>
            <td>Rp ${(item.harga * item.qty).toLocaleString('id')}</td>
        </tr>`;
        inputItems.innerHTML += `
            <input type="hidden" name="items[${i}][produk_id]" value="${item.id}">
            <input type="hidden" name="items[${i}][qty]" value="${item.qty}">
        `;
    });

    document.getElementById('total-harga').innerText = total.toLocaleString('id');
}
</script>
@endpush