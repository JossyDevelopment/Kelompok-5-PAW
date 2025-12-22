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
    Schema::create('master_jenis_bantuan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_bantuan'); // Contoh: Benih lele Unggul
        $table->string('kategori');     // Contoh: Benih, Pakan
        $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
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
        Schema::dropIfExists('master_jenis_bantuan');
    }
};
