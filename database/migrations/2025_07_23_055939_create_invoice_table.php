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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('klien_id');
            $table->string('kode_invoice')->unique();
            $table->date('tanggal_invoice');
            $table->decimal('total_tagihan', 14, 2)->default(0);
            $table->enum('status', ['belum_bayar', 'sudah_bayar', 'dp'])->default('belum_bayar');
            $table->text('keterangan')->nullable();
        
            $table->timestamps();
        
            $table->foreign('klien_id')->references('id')->on('klien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
