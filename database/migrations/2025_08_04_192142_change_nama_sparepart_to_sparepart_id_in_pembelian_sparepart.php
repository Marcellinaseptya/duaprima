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
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->unsignedBigInteger('sparepart_id')->after('id');
            $table->dropColumn('nama_sparepart');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            //
        });
    }
};
