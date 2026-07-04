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
            $table->string('supplier')->nullable()->after('harga_total');
        });
    }
    
    public function down()
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->dropColumn('supplier');
        });
    }
};
