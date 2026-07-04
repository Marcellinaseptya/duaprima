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
        Schema::create('catatan_manajer', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('user_id'); // ID user manajer
            $table->date('tanggal');
            $table->string('judul')->nullable();
            $table->text('isi');
            $table->string('lampiran')->nullable(); // path file bukti
        
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_manajer');
    }
};
