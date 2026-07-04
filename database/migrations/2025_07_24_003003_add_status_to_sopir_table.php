<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sopir', function (Blueprint $table) {
            if (!Schema::hasColumn('sopir', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('alamat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sopir', function (Blueprint $table) {
            if (Schema::hasColumn('sopir', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};