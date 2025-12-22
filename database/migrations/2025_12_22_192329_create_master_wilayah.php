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
    Schema::create('master_wilayah', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // Contoh: Kabupaten Bogor
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
        Schema::dropIfExists('master_wilayah');
    }
};
