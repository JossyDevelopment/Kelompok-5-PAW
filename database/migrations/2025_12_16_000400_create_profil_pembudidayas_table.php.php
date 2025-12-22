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
        $table->unsignedBigInteger('id_user');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

        // Gunakan nullable() agar tidak error saat data ini belum diisi
        $table->unsignedBigInteger('id_wilayah')->nullable(); 
        $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah');

        $table->string('nama');
        $table->string('NIK')->nullable();
        $table->text('alamat')->nullable();
        $table->string('kecamatan')->nullable(); // Tambahkan nullable()
        $table->string('desa')->nullable();      // Tambahkan nullable()
        $table->string('nomor_hp')->nullable();
        $table->string('tipe_pembudidaya')->default('Perorangan'); // Beri nilai default
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
        Schema::dropIfExists('profil_pembudidaya'); 
    }
};
