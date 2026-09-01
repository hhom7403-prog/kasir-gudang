<?php

namespace App\Services;

use App\Models\MutasiStok;
use App\Models\Stok;
use Exception;

class StokService
{
    public function kurangiStok($produkId, $gudangId, $qty, $keterangan = '')
    {
        $stok = Stok::where('produk_id', $produkId)
            ->where('gudang_id', $gudangId)
            ->lockForUpdate() // hindari race condition saat transaksi bersamaan
            ->first();

        if (! $stok || $stok->jumlah_stok < $qty) {
            throw new Exception('Stok tidak mencukupi untuk produk ini.');
        }

        $stok->jumlah_stok -= $qty;
        $stok->save();

        MutasiStok::create([
            'stok_id' => $stok->id,
            'jenis' => 'keluar',
            'jumlah' => $qty,
            'keterangan' => $keterangan,
        ]);

        return $stok;
    }

    public function tambahStok($produkId, $gudangId, $qty, $keterangan = 'Restock manual')
    {
        $stok = Stok::where('produk_id', $produkId)
            ->where('gudang_id', $gudangId)
            ->lockForUpdate()->first();
        if (! $stok) {
            $stok = Stok::create(['produk_id' => $produkId, 'gudang_id' => $gudangId, 'jumlah_stok' => 0]);
        }

        $stok->jumlah_stok += $qty;
        $stok->save();

        MutasiStok::create([
            'stok_id' => $stok->id,
            'jenis' => 'masuk',
            'jumlah' => $qty,
            'keterangan' => $keterangan,
        ]);

        return $stok;
    }
}
