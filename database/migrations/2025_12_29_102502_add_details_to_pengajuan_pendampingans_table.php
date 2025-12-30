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
   public function up(): void
{
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        // Menambahkan kolom jam dan keterangan petugas
        $table->time('jam_kunjungan')->nullable()->after('jadwal_pendampingan');
        $table->text('keterangan_petugas')->nullable()->after('jam_kunjungan');
    });
}

public function down(): void
{
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        $table->dropColumn(['jam_kunjungan', 'keterangan_petugas']);
    });
}
};
