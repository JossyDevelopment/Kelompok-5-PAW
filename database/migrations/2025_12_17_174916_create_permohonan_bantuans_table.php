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
        Schema::create('permohonan_bantuans', function (Blueprint $table) {
            $table->id();
        $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade'); // Relasi ke User
        
        // Data Pengajuan
        $table->string('no_tiket')->unique(); // Misal: PB-20251010-001
        $table->enum('jenis_bantuan', ['benih', 'pakan', 'alat']);
        $table->text('detail_kebutuhan');
        $table->string('file_proposal')->nullable(); // Path file upload
        $table->string('file_legalitas')->nullable();
        
        // Status Workflow
        // pending -> verifikasi_upt -> disetujui_admin -> dikirim -> selesai
        $table->string('status')->default('pending'); 
        $table->text('catatan_petugas')->nullable(); // Jika ditolak/revisi

        // Data Penerimaan (Diisi saat menu Penerimaan)
        $table->date('tanggal_diterima')->nullable();
        $table->text('catatan_penerimaan')->nullable();
        $table->string('foto_bukti_terima')->nullable();

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
        Schema::dropIfExists('permohonan_bantuans');
    }
};
