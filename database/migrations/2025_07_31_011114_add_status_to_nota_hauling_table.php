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
        Schema::table('nota_hauling', function (Blueprint $table) {
            $table->string('status')->default('Menunggu Validasi');
        });
    }
    
    public function down()
    {
        Schema::table('nota_hauling', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};