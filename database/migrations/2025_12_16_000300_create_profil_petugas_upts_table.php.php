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
    Schema::create('profil_petugas_upt', function (Blueprint $table) {
        $table->id('id_profil_petugas');
        // Foreign Key ke Users
        $table->unsignedBigInteger('id_user');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

        $table->string('nama');
        $table->string('upt_wilayah');
        $table->string('nomor_hp');
        $table->string('jabatan');
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
        Schema::dropIfExists('profil_petugas_upt');
    }
};
