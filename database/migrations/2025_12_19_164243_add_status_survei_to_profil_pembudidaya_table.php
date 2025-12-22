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
        Schema::table('profil_pembudidaya', function (Blueprint $table) {
            // Menambahkan kolom status survei setelah kolom alamat
            $table->enum('status_survei', ['belum', 'sudah'])->default('belum')->after('alamat');
        });
    }

    public function down()
    {
        Schema::table('profil_pembudidaya', function (Blueprint $table) {
            $table->dropColumn('status_survei');
        });
    }
};
