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
    Schema::table('sopir', function (Blueprint $table) {
        $table->string('plat_truk')->nullable(); // atau ->after('nama_kolom') kalau mau spesifik urutan
    });
}

public function down()
{
    Schema::table('sopirs', function (Blueprint $table) {
        $table->dropColumn('plat_truk');
    });
}

};
