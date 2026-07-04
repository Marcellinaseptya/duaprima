<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasColumn('maintenance', 'truk_id')) {
            Schema::table('maintenance', function (Blueprint $table) {
                // Menghapus constraint foreign key terlebih dahulu
                $table->dropForeign(['truk_id']);
                // Baru kemudian menghapus kolomnya
                $table->dropColumn('truk_id');
            });
        }
    }
    
    public function down()
    {
        if (!Schema::hasColumn('maintenance', 'truk_id')) {
            Schema::table('maintenance', function (Blueprint $table) {
                $table->unsignedBigInteger('truk_id')->after('id')->nullable();
            });
        }
    }
    
};
