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
        Schema::table('trip_berangkat', function (Blueprint $table) {
            $table->integer('km_awal')->nullable()->after('lokasi_berangkat');
        });

        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->integer('km_akhir')->nullable()->after('jadwal_id');
            $table->string('lokasi_tujuan')->nullable()->after('km_akhir');
            $table->date('tanggal_sampai')->nullable()->after('lokasi_tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_berangkat', function (Blueprint $table) {
            $table->dropColumn('km_awal');
        });

        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->dropColumn(['km_akhir', 'lokasi_tujuan', 'tanggal_sampai']);
        });
    }
};
