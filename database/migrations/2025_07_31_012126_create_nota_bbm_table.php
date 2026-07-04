<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaBbmTable extends Migration
{
    public function up()
    {
        Schema::create('nota_bbm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sopir_id');
            $table->string('file');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nota_bbm');
    }
}