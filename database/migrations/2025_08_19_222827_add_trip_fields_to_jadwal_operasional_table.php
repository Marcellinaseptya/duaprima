<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_operasional', function (Blueprint $table) {
            $table->integer('uang_jalan')->nullable();
            $table->integer('uang_makan')->nullable();
            $table->string('nota_perjalanan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_operasional', function (Blueprint $table) {
            //
        });
    }
};
