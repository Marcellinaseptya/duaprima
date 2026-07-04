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
        Schema::create('master_truk', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->string('jenis')->nullable();
            $table->integer('kapasitas')->nullable(); // dalam kg
            $table->year('tahun')->nullable();
            $table->enum('status', ['aktif', 'servis', 'rusak', 'nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_truk');
    }
};
