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

        Schema::create('dokumen_pendukung', function (Blueprint $table) {
        $table->id('id_dokumen');

        $table->unsignedBigInteger('id_profil_pembudidaya');
        $table->foreign('id_profil_pembudidaya')->references('id_profil_pembudidaya')->on('profil_pembudidaya')->onDelete('cascade');

        $table->string('nama_dokumen');
        $table->string('lokasi_file'); // Path file
        $table->date('tanggal_upload');
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
        Schema::dropIfExists('dokumen_pendukung');
    }
};
