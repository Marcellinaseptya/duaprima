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
        Schema::create('pinjaman_sopir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id');
            $table->date('tanggal_pinjam');
            $table->decimal('jumlah', 14, 2);
            $table->decimal('sisa', 14, 2);
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        
            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman_sopir');
    }
};
