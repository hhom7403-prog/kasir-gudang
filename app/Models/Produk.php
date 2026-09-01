<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['kategori_id', 'kode_produk', 'nama_produk', 'deskripsi', 'harga_beli', 'harga_jual', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }
}
