<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_operasional', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');
            $table->unsignedBigInteger('sopir_id'); // relasi ke sopir
            $table->unsignedBigInteger('truk_id');  // relasi ke master_truk
            $table->unsignedBigInteger('klien_id')->nullable(); // relasi ke klien

            $table->string('tujuan')->nullable(); // ex: TAPIN
            $table->string('rute')->nullable(); // lokasi dumping atau tempat muat
            $table->integer('bruto')->nullable(); // muatan awal
            $table->integer('tara')->nullable();  // berat kosong
            $table->integer('netto')->nullable(); // hasil akhir muatan
            $table->string('no_surat_jalan')->nullable(); // jika ingin catat SJ

            $table->text('catatan')->nullable(); // contoh: Berangkat Batu Bara Tapin

            $table->timestamps();

            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
            $table->foreign('truk_id')->references('id')->on('master_truk')->onDelete('cascade');
            $table->foreign('klien_id')->references('id')->on('klien')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_operasional');
    }
};