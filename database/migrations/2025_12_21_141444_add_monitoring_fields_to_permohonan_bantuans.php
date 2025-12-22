<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('permohonan_bantuans', function (Blueprint $table) {
        // Tambahkan kolom untuk menyimpan tanggal monitoring
        $table->date('tanggal_monitoring_terakhir')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_bantuans', function (Blueprint $table) {
            //
        });
    }
};
