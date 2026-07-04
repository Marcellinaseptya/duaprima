<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nota_hauling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id');
            $table->date('tanggal');
            $table->integer('jumlah_rit');
            $table->decimal('tarif_per_rit', 14, 2);
            $table->decimal('bonus', 14, 2)->default(0);
            $table->decimal('total_pemasukan', 14, 2);
            $table->string('file_nota')->nullable(); // untuk upload nota JPG/PNG/PDF
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_hauling');
    }
};
