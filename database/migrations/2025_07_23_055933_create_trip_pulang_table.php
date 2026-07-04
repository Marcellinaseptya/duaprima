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
        Schema::create('trip_pulang', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('trip_berangkat_id');
            $table->date('tanggal_pulang')->nullable();
            $table->string('kondisi_truk')->nullable();
            $table->string('sisa_muatan')->nullable();
            $table->text('catatan')->nullable();
        
            $table->timestamps();
        
            $table->foreign('trip_berangkat_id')->references('id')->on('trip_berangkat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_pulang');
    }
};
