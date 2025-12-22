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
    Schema::create('master_topik_pendamping', function (Blueprint $table) {
        $table->id();
        $table->string('nama_topik'); // Contoh: Teknik Budidaya Bioflok
        $table->string('kategori');   // Contoh: Budidaya Intensif
        $table->text('deskripsi');     // Kolom baru sesuai gambar
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
        Schema::dropIfExists('master_topik_pendamping');
    }
};
