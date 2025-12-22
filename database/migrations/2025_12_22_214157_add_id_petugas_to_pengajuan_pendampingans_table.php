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
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        // 1. Tambahkan kolom jika belum ada
        if (!Schema::hasColumn('pengajuan_pendampingans', 'id_petugas')) {
            $table->unsignedBigInteger('id_petugas')->after('id_user')->nullable();
        }

        // 2. Perbaiki referensi kolom ke id_user (bukan id)
        $table->foreign('id_petugas')
              ->references('id_user') // Ubah ini
              ->on('users')
              ->onDelete('set null');
    });
}
};
