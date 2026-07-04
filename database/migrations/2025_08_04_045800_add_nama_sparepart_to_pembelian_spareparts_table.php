<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pembelian_sparepart', function (Blueprint $table) {
        $table->string('nama_sparepart')->after('id');
        $table->dropForeign(['sparepart_id']);
        $table->dropColumn('sparepart_id');
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
