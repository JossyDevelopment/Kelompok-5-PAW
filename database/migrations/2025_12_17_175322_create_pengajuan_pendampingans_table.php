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
        Schema::create('pengajuan_pendampingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            
            $table->string('topik'); // Kualitas Air, Pakan, dll
            $table->text('detail_keluhan');
            
            $table->string('status')->default('pending'); // pending, dijadwalkan, selesai
            
            // Diisi oleh Petugas/Admin nanti
            $table->dateTime('jadwal_pendampingan')->nullable();
            $table->string('nama_petugas')->nullable();
            
            // Feedback dari Pembudidaya
            $table->integer('rating')->nullable(); // Bintang 1-5
            $table->text('ulasan_feedback')->nullable();

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
        Schema::dropIfExists('pengajuan_pendampingans');
    }
};
