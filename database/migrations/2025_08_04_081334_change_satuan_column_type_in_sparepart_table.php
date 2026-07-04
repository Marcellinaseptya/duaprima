<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSatuanColumnTypeInSparepartTable extends Migration
{
    public function up()
    {
        Schema::table('sparepart', function (Blueprint $table) {
            $table->string('satuan', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('sparepart', function (Blueprint $table) {
            $table->decimal('satuan', 1, 0)->change(); // ini hanya rollback
        });
    }
};


