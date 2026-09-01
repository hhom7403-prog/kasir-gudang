<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_id')->constrained('stoks')->onDelete('cascade');
            $table->enum('jenis', ['masuk', 'keluar', 'penyesuaian']);
            $table->integer('jumlah');
            $table->string('keterangan')->nullable(); // misal: "Transaksi #TRX001" atau "Restock"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_stoks');
    }
};
