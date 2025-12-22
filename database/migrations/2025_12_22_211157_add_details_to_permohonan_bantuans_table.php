<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonan_bantuans', function (Blueprint $table) {
            // Menambahkan kolom sesuai kebutuhan pop-up detail
            $table->string('no_permohonan')->nullable()->after('id'); 
            $table->bigInteger('nilai_estimasi')->default(0)->after('detail_kebutuhan');
            $table->enum('skala_prioritas', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang')->after('nilai_estimasi');
        });
    }

    public function down()
    {
        Schema::table('permohonan_bantuans', function (Blueprint $table) {
            $table->dropColumn(['no_permohonan', 'nilai_estimasi', 'skala_prioritas']);
        });
    }
};