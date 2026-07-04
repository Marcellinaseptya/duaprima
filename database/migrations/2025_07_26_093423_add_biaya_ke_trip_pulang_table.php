<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->decimal('uang_tol', 14, 2)->nullable()->after('catatan');
            $table->decimal('uang_makan', 14, 2)->nullable()->after('uang_tol');
            $table->decimal('bbm', 14, 2)->nullable()->after('uang_makan');
            $table->decimal('uang_parkir', 14, 2)->nullable()->after('bbm');
        });
    }

    public function down(): void
    {
        Schema::table('trip_pulang', function (Blueprint $table) {
            $table->dropColumn(['uang_tol', 'uang_makan', 'bbm', 'uang_parkir']);
        });
    }
};