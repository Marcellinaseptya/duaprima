<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('trip_berangkat', function (Blueprint $table) {
            $table->decimal('uang_makan', 14, 2)->nullable()->default(0)->after('tujuan');
            $table->decimal('uang_tol', 14, 2)->nullable()->default(0)->after('uang_makan');
            $table->decimal('bbm', 14, 2)->nullable()->default(0)->after('uang_tol');
            $table->decimal('uang_parkir', 14, 2)->nullable()->default(0)->after('bbm');
        });
    }

    public function down(): void
    {
        Schema::table('trip_berangkat', function (Blueprint $table) {
            $table->dropColumn(['uang_makan', 'uang_tol', 'bbm', 'uang_parkir']);
        });
    }
};