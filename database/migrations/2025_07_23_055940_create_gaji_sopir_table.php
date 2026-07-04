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
        Schema::create('gaji_sopir', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('sopir_id');
            $table->date('periode'); // cukup bulan dan tahun, tanggalnya bisa 01
            $table->decimal('total_gaji', 14, 2)->default(0);
            $table->enum('status', ['belum_dibayar', 'lunas'])->default('belum_dibayar');
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
        Schema::dropIfExists('gaji_sopir');
    }
};
