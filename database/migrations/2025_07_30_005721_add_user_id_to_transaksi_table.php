<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('sopir_id')->nullable()->after('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sopir_id')->references('id')->on('sopir')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sopir_id']);

            $table->dropColumn('user_id');
            $table->dropColumn('sopir_id');
        });
    }
};