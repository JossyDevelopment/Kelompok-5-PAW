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
        // Hanya tambahkan tanggal_survei karena status_survei sudah ada
        $table->date('tanggal_survei')->nullable()->after('status_survei');
    });
}

public function down()
{
    Schema::table('profil_pembudidaya', function (Blueprint $table) {
        $table->dropColumn('tanggal_survei');
    });
}
};
