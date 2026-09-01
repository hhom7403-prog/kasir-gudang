<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    protected $stokService;

    public function __construct(StokService $stokService)
    {
        $this->stokService = $stokService;
    }

    public function index()
    {
        $stoks = Stok::with(['produk', 'gudang'])->get();

        return view('gudang.stok.index', compact('stoks'));
    }

    public function restock(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'gudang_id' => 'required|exists:gudangs,id',
            'qty' => 'required|integer|min:1',
        ]);

        DB::transaction(fn () => $this->stokService->tambahStok(
            $request->produk_id,
            $request->gudang_id,
            $request->qty
        ));

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    public function stokMenipis()
    {
        $stoks = Stok::whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->with(['produk', 'gudang'])->get();

        return view('gudang.stok.menipis', compact('stoks'));
    }
}
