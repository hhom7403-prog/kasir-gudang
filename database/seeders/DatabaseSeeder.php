<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $kategoriNames = ['Sembako', 'Minuman', 'Makanan', 'Kebersihan', 'Perawatan'];
        $kategoris = collect($kategoriNames)->mapWithKeys(fn (string $name) => [
            $name => Kategori::updateOrCreate(['nama_kategori' => $name]),
        ]);

        $gudangNames = [
            ['nama_gudang' => 'Gudang Utama', 'lokasi' => 'Jakarta'],
            ['nama_gudang' => 'Gudang Barat', 'lokasi' => 'Tangerang'],
            ['nama_gudang' => 'Gudang Timur', 'lokasi' => 'Bekasi'],
            ['nama_gudang' => 'Gudang Selatan', 'lokasi' => 'Depok'],
            ['nama_gudang' => 'Gudang Utara', 'lokasi' => 'Bogor'],
        ];
        $gudangs = collect($gudangNames)->map(fn (array $data) => Gudang::updateOrCreate(
            ['nama_gudang' => $data['nama_gudang']], $data
        ));

        $productNames = [
            'Beras 5kg', 'Gula Pasir 1kg', 'Minyak Goreng 1L', 'Tepung Terigu 1kg',
            'Telur Ayam 1kg', 'Air Mineral 600ml', 'Teh Celup', 'Kopi Bubuk 100g',
            'Susu UHT 1L', 'Sirup  Marjan', 'Mi Instan Goreng', 'Biskuit Cokelat',
            'Roti Tawar', 'Sarden Kaleng', 'Sabun Mandi', 'Sampo 170ml',
            'Pasta Gigi', 'Deterjen 1kg', 'Cairan Pel Lantai', 'Tisu Gulung',
        ];

        foreach ($productNames as $index => $name) {
            $produk = Produk::updateOrCreate(
                ['kode_produk' => 'PRD-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'kategori_id' => $kategoris->values()->get($index % $kategoris->count())->id,
                    'nama_produk' => $name,
                    'deskripsi' => 'Produk dummy untuk pengujian aplikasi kasir dan gudang.',
                    'harga_beli' => 5000 + ($index * 1250),
                    'harga_jual' => 7500 + ($index * 1750),
                ]
            );

            foreach ($gudangs as $gudang) {
                Stok::updateOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => $gudang->id],
                    ['jumlah_stok' => 20, 'stok_minimum' => 5]
                );
            }
        }
    }
}
