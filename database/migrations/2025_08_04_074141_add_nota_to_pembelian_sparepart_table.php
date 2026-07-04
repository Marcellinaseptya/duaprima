<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->enum('nota', ['ada', 'tidak ada'])->after('jumlah')->default('tidak ada');
        });
    }

    public function down(): void
    {
        Schema::table('pembelian_sparepart', function (Blueprint $table) {
            $table->dropColumn('nota');
        });
    }
};
    