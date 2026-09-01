<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $fillable = ['nama_gudang', 'lokasi'];

    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
