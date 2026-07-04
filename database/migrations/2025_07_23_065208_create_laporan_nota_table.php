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
        Schema::create('laporan_nota', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('sopir_id');
            $table->enum('jenis', ['hauling', 'bbm', 'perbaikan']);
            $table->string('file_nota');
            $table->date('tanggal_upload');
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
        Schema::dropIfExists('laporan_nota');
    }
};
