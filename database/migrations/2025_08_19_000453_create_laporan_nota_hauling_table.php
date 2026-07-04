<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_nota_hauling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sopir_id')->constrained('sopir')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('file_nota');
            $table->string('bukti_transfer');
            $table->integer('tarif_per_rit');
            $table->integer('jumlah_ritase');
            $table->enum('status', ['MENUNGGU', 'APPROVED', 'REJECTED'])->default('MENUNGGU');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_nota_hauling');
    }
};
