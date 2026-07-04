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
        Schema::create('trip_berangkat', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('sopir_id');
            $table->unsignedBigInteger('master_truk_id');
            $table->unsignedBigInteger('klien_id');
        
            $table->date('tanggal_berangkat');
            $table->string('tujuan')->nullable();
            $table->string('muatan_awal')->nullable();
            $table->text('catatan')->nullable();
        
            $table->timestamps();
        
            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
            $table->foreign('master_truk_id')->references('id')->on('master_truk')->onDelete('cascade');
            $table->foreign('klien_id')->references('id')->on('klien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_berangkat');
    }
};
