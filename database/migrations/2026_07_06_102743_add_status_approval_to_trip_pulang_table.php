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
        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->enum('status_approval', ['Menunggu Validasi', 'Disetujui', 'Ditolak'])->default('Menunggu Validasi')->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->dropColumn('status_approval');
        });
    }
};
