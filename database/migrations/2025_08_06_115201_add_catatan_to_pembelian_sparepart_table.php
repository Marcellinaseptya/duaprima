<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('tanggal_pembelian');
        });
    }

    public function down()
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};