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
        Schema::create('pembelian_sparepart', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('sparepart_id');
            $table->integer('jumlah');
            $table->decimal('harga_total', 14, 2);
            $table->string('supplier')->nullable();
            $table->date('tanggal_pembelian');
            $table->text('catatan')->nullable();
        
            $table->timestamps();
        
            $table->foreign('sparepart_id')->references('id')->on('sparepart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_sparepart');
    }
};
