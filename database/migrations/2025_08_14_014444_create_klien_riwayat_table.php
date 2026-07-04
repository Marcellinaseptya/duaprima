<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klien_riwayat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klien_id')->constrained('klien')->onDelete('cascade');
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamp('mulai')->nullable();
            $table->timestamp('berhenti')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien_riwayat');
    }
};
