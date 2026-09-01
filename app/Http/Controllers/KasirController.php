<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    protected $stokService;

    public function __construct(StokService $stokService)
    {
        $this->stokService = $stokService;
    }

    public function index()
    {
        $gudangs = Gudang::orderBy('nama_gudang')->get();
        $gudangId = request('gudang_id', $gudangs->first()?->id);
        $produks = Produk::with(['stoks' => fn ($q) => $q->where('gudang_id', $gudangId)])
            ->orderBy('nama_produk')->get();

        return view('kasir.index', compact('produks', 'gudangs', 'gudangId'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
            'gudang_id' => 'required|exists:gudangs,id',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);
                $total += $produk->harga_jual * $item['qty'];
            }

            if ($request->bayar < $total) {
                throw new \RuntimeException('Jumlah pembayaran kurang dari total transaksi.');
            }

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-'.strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'gudang_id' => $request->gudang_id,
                'total_harga' => $total,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $total,
                'status' => 'selesai',
            ]);

            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // Kurangi stok gudang secara real-time
                $this->stokService->kurangiStok(
                    $produk->id,
                    $request->gudang_id,
                    $item['qty'],
                    'Transaksi '.$transaksi->kode_transaksi
                );

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'qty' => $item['qty'],
                    'harga_satuan' => $produk->harga_jual,
                    'subtotal' => $produk->harga_jual * $item['qty'],
                ]);
            }

            DB::commit();

            return redirect()->route('kasir.struk', $transaksi->id)
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('detail.produk')->findOrFail($id);

        return view('kasir.struk', compact('transaksi'));
    }
}
