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
    public function up(): void
{
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        $table->dateTime('waktu_realisasi_selesai')->nullable()->after('jam_kunjungan');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
            //
        });
    }
};
