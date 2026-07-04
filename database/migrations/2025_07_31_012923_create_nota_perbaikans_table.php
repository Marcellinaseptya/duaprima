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
        Schema::create('nota_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id')->nullable();
            $table->string('file_nota'); // path nota (pdf/jpg/png)
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Menunggu Validasi', 'Disetujui', 'Ditolak'])->default('Menunggu Validasi');
            $table->timestamps();
    
            $table->foreign('sopir_id')->references('id')->on('Sopir')->onDelete('set null');
        });
    }
};
