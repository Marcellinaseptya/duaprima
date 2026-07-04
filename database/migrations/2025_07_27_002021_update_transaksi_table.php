<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Ubah kolom jumlah menjadi nominal decimal
            $table->decimal('nominal', 14, 2)->after('tanggal');
            $table->dropColumn('jumlah');

            // Tambahkan sumber transaksi (contoh: ritase, peminjaman, dll)
            $table->string('sumber')->nullable()->after('nominal');

            // Tambahkan status lunas (khusus peminjaman)
            $table->enum('status_lunas', ['belum', 'lunas'])->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('jumlah')->after('tanggal');
            $table->dropColumn('nominal');
            $table->dropColumn('sumber');
            $table->dropColumn('status_lunas');
        });
    }
};