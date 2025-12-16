<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // PK sesuai ERD
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('nama_lengkap');
            $table->string('nomor_hp');
            $table->string('role'); // misal: 'admin', 'pembudidaya', 'petugas'
            
            // PERUBAHAN 1: Default status sebaiknya false (belum aktif) sampai verifikasi OTP
            $table->boolean('status_aktif')->default(false); 
            
            // PERUBAHAN 2: Tambahkan kolom OTP (PENTING!)
            $table->string('otp_code')->nullable();       // Menyimpan kode 4 digit
            $table->timestamp('otp_expired_at')->nullable(); // Menyimpan waktu kadaluarsa
            
            $table->timestamp('tanggal_dibuat')->useCurrent();
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
        Schema::dropIfExists('users');
    }
}