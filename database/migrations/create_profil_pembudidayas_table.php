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
    Schema::create('profil_pembudidaya', function (Blueprint $table) {
        $table->id('id_profil_pembudidaya');

        // FK ke Users
        $table->unsignedBigInteger('id_user');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

        // FK ke Wilayah
        $table->unsignedBigInteger('id_wilayah');
        $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah');

        $table->string('nama');
        $table->string('NIK');
        $table->text('alamat');
        $table->string('kecamatan'); // Data redudansi (opsional jika sudah ada id_wilayah)
        $table->string('desa');      // Data redudansi (opsional jika sudah ada id_wilayah)
        $table->string('nomor_hp');
        $table->string('tipe_pembudidaya');
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
        Schema::dropIfExists('password_resets');
    }
};
