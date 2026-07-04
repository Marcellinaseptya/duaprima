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
        Schema::table('maintenance', function (Blueprint $table) {
            $table->unsignedBigInteger('mastertruk_id')->after('id');
            $table->foreign('mastertruk_id')->references('id')->on('master_truk')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $table->dropForeign(['mastertruk_id']);
            $table->dropColumn('mastertruk_id');
        });
    }
    
};
