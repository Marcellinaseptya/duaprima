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
        Schema::table('ritase', function (Blueprint $table) {
            $table->unsignedBigInteger('sopir_id')->after('id');
    
            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('ritase', function (Blueprint $table) {
            $table->dropForeign(['sopir_id']);
            $table->dropColumn('sopir_id');
        });
    }
    

    
};
