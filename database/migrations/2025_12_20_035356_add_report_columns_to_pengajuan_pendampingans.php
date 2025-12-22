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
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        $table->text('hasil_pendampingan')->nullable()->after('nama_petugas');
        $table->string('file_dokumentasi')->nullable()->after('hasil_pendampingan');
        $table->text('rekomendasi_tindak_lanjut')->nullable()->after('file_dokumentasi');
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
