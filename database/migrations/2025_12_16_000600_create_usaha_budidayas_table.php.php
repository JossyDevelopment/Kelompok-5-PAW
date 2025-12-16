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
        Schema::create('usaha_budidaya', function (Blueprint $table) {
        $table->id('id_usaha');
        
        $table->unsignedBigInteger('id_profil_pembudidaya');
        $table->foreign('id_profil_pembudidaya')->references('id_profil_pembudidaya')->on('profil_pembudidaya')->onDelete('cascade');

        $table->string('jenis_ikan');
        $table->string('tipe_kolam');
        $table->string('luas_kolam'); // Bisa diganti decimal/float jika perlu kalkulasi
        $table->string('kapasitas_produksi');
        $table->integer('jumlah_kolam');
        $table->timestamps();
    });
        //
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usaha_budidaya');
    }
};
