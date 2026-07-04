<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id');
            $table->unsignedBigInteger('truk_id');
            $table->date('tanggal');
            $table->text('deskripsi_kerusakan');
            $table->string('foto')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_manajer')->nullable();
            $table->timestamps();
    
            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
            $table->foreign('truk_id')->references('id')->on('master_truk')->onDelete('cascade');
        });
    }
    
};