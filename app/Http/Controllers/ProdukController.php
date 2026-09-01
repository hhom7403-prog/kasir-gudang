<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->orderBy('nama_produk')->paginate(15);

        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create', ['kategoris' => Kategori::orderBy('nama_kategori')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_produk' => 'required|string|max:100|unique:produks,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);
        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', ['produk' => $produk, 'kategoris' => Kategori::orderBy('nama_kategori')->get()]);
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_produk' => 'required|string|max:100|unique:produks,kode_produk,'.$produk->id,
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);
        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
