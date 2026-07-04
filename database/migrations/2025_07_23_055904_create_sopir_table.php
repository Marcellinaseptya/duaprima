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
        Schema::create('sopir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // agar sopir bisa login
            $table->string('nama');
            $table->string('no_ktp')->nullable();
            $table->string('no_sim')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('aktif')->default(true); // status aktif
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sopir');
    }
};
