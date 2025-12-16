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
        Schema::create('penugasan', function (Blueprint $table) {
        $table->id('id_penugasan');

        $table->unsignedBigInteger('id_profil_pembudidaya');
        $table->foreign('id_profil_pembudidaya')->references('id_profil_pembudidaya')->on('profil_pembudidaya');

        $table->unsignedBigInteger('id_profil_petugas');
        $table->foreign('id_profil_petugas')->references('id_profil_petugas')->on('profil_petugas_upt');

        $table->string('status_tugas');
        $table->date('tanggal_tugas');
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
        Schema::dropIfExists('penugasan');
    }
};
