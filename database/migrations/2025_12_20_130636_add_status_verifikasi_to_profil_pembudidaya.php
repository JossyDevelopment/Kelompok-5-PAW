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
        // Menambahkan kolom yang dicari oleh Controller Anda
        $table->string('status_verifikasi')->default('baru')->after('tipe_pembudidaya');
        $table->text('catatan_verifikasi')->nullable()->after('status_verifikasi');
    });
}

public function down()
{
    Schema::table('profil_pembudidaya', function (Blueprint $table) {
        $table->dropColumn(['status_verifikasi', 'catatan_verifikasi']);
    });
}
};
