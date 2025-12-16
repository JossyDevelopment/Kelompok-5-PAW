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
        Schema::create('verifikasi', function (Blueprint $table) {
        $table->id('id_verifikasi');

        $table->unsignedBigInteger('id_profil_pembudidaya');
        $table->foreign('id_profil_pembudidaya')->references('id_profil_pembudidaya')->on('profil_pembudidaya');

        $table->unsignedBigInteger('id_profil_petugas');
        $table->foreign('id_profil_petugas')->references('id_profil_petugas')->on('profil_petugas_upt');

        $table->string('status_verifikasi');
        $table->text('catatan')->nullable();
        $table->date('tanggal_verifikasi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifikasi');
    }
};
