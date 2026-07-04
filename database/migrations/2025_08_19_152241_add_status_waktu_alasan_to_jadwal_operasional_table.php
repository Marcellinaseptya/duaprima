<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jadwal_operasional', function (Blueprint $table) {
            $table->string('status', 50)->default('Menunggu')->after('netto');
            $table->dateTime('waktu_mulai')->nullable()->after('status');
            $table->dateTime('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->string('alasan_batal', 255)->nullable()->after('waktu_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_operasional', function (Blueprint $table) {
            $table->dropColumn(['status', 'waktu_mulai', 'waktu_selesai', 'alasan_batal']);
        });
    }
};