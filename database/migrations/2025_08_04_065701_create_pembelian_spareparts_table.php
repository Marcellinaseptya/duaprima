<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembelian_spareparts', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pembelian');
            $table->string('nama_sparepart');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2); // ini dihitung otomatis di controller
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_spareparts');
    }
};
