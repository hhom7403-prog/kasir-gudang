@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6"><div class="flex justify-between items-center mb-5"><h1 class="text-2xl font-bold">Kasir</h1><form method="GET"><select name="gudang_id" onchange="this.form.submit()" class="border p-2"><option value="">Pilih gudang</option>@foreach($gudangs as $gudang)<option value="{{ $gudang->id }}" @selected($gudangId == $gudang->id)>{{ $gudang->nama_gudang }}</option>@endforeach</select></form></div>@include('components.flash')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($produks as $produk)
        <button type="button" class="border rounded-lg p-3 text-left produk-card hover:border-blue-500 disabled:opacity-40"
             data-id="{{ $produk->id }}"
             data-nama="{{ $produk->nama_produk }}"
             data-harga="{{ $produk->harga_jual }}"
             data-stok="{{ $produk->stoks->first()->jumlah_stok ?? 0 }}" @disabled(!$gudangId || ($produk->stoks->first()->jumlah_stok ?? 0) < 1)>
            <h3 class="font-semibold">{{ $produk->nama_produk }}</h3>
            <p>Rp {{ number_format($produk->harga_jual,0,',','.') }}</p>
            <small>Stok: {{ $produk->stoks->first()->jumlah_stok ?? 0 }}</small>
        </button>
        @endforeach
    </div>

    <div class="border rounded-lg p-4 bg-white">
        <h2 class="font-bold mb-2">Keranjang</h2>
        <table class="w-full text-sm" id="tabel-keranjang">
            <tbody></tbody>
        </table>
        <hr class="my-2">
        <p>Total: Rp <span id="total-harga">0</span></p>

        <form action="{{ route('kasir.simpan') }}" method="POST" id="form-transaksi">
            @csrf
            <input type="hidden" name="gudang_id" value="{{ $gudangId }}">
            <div id="input-items"></div>
            <input type="number" name="bayar" placeholder="Jumlah Bayar" class="border w-full p-2 my-2" required>
            <button type="submit" class="bg-blue-600 text-white w-full py-2 rounded" @disabled(!$gudangId)>Bayar</button>
        </form>
    </div>
</div></div>
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