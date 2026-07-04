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
    Schema::table('sparepart', function (Blueprint $table) {
        $table->string('satuan')->after('stok');
    });
}

public function down()
{
    Schema::table('sparepart', function (Blueprint $table) {
        $table->dropColumn('satuan');
    });
}
};
