<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ritase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_berangkat_id')
                  ->constrained('trip_berangkat') // rujuk ke tabel 'trip_berangkat' secara eksplisit
                  ->onDelete('cascade');

            $table->decimal('muatan_netto', 10, 2);
            $table->decimal('tarif', 10, 2);
            $table->decimal('biaya_bbm', 10, 2);
            $table->decimal('gaji_sopir', 10, 2); // otomatis 25% dari hasil bersih
            $table->decimal('keuntungan_cv', 10, 2); // otomatis 75% dari hasil bersih
            $table->decimal('bonus', 10, 2)->default(0); // jika muatan > 11.500
            $table->decimal('harga_terbaru', 10, 2)->nullable(); // jika ada tarif baru
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ritase');
    }
};