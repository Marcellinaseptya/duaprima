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
        Schema::create('nota_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id');
            $table->string('jenis'); // 'bbm', 'perbaikan', dll
            $table->string('file_bukti')->nullable(); // upload gambar/pdf
            $table->date('tanggal');
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
        //
    }
};
