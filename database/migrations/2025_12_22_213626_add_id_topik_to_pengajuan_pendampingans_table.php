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
        // Menambahkan kolom id_topik sebagai foreign key
        $table->unsignedBigInteger('id_topik')->after('id_user')->nullable();
        
        // Opsional: Tambahkan relasi foreign key agar data konsisten
        $table->foreign('id_topik')
              ->references('id')
              ->on('master_topik_pendamping')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('pengajuan_pendampingans', function (Blueprint $table) {
        $table->dropForeign(['id_topik']);
        $table->dropColumn('id_topik');
    });
}
};
