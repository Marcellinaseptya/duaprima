<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameHargaTotalToTotalHargaInPembelianSparepartTable extends Migration
{
    public function up()
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->renameColumn('total_harga', 'harga_total');
        });
    }

    public function down()
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->renameColumn('total_harga', 'harga_total');
        });
    }
};