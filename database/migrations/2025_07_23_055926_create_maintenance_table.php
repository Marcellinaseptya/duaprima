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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_kerusakan_id')->nullable();
            $table->unsignedBigInteger('truk_id');
            $table->date('tanggal_perbaikan');
            $table->text('deskripsi_perbaikan');
            $table->decimal('biaya', 12, 2);
            $table->string('foto_bukti')->nullable();
            $table->timestamps();
    
            $table->foreign('laporan_kerusakan_id')->references('id')->on('laporan_kerusakan')->onDelete('set null');
            $table->foreign('truk_id')->references('id')->on('master_truk')->onDelete('cascade');
        });
    }
    
};
