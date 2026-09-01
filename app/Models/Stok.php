<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = ['produk_id', 'gudang_id', 'jumlah_stok', 'stok_minimum'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function mutasi()
    {
        return $this->hasMany(MutasiStok::class);
    }
}
