<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PermohonanBantuan;
use App\Models\PengajuanPendampingan;
use App\Models\ProfilPembudidaya;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function verifikasiBudidaya()
    {
        // Data Dummy Statistik (Nanti diganti count() dari database)
      // Hitung jumlah user yang role pembudidaya DAN sudah memiliki record di tabel profil
    $permohonanBaru = ProfilPembudidaya::count();

    $stats = [
        'permohonan_baru' => $permohonanBaru,
        'menunggu_validasi' => PermohonanBantuan::where('status', 'pending')->count(),
        'perlu_dijadwalkan' => PengajuanPendampingan::where('status', 'pending')->count()
    ];

    return view('petugas.verifikasi-budidaya', compact('stats'));
    }

    public function listVerifikasiData()
{
    $pembudidaya = User::join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        // Ambil status dari tabel verifikasi
        ->leftJoin('verifikasi', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'verifikasi.id_profil_pembudidaya')
        ->where('users.role', 'pembudidaya')
        ->select(
            'users.*', 
            'profil_pembudidaya.NIK', 
            'profil_pembudidaya.nama as nama_lengkap',
            'verifikasi.status_verifikasi', // Ini yang akan dibaca oleh Blade
            'usaha_budidaya.luas_kolam as luas_lahan',
            'usaha_budidaya.jumlah_kolam'
        )
        ->latest('verifikasi.created_at') // Ambil hasil verifikasi terbaru
        ->paginate(10);

    return view('petugas.verifikasi-pembudidaya-list', compact('pembudidaya'));
}
// app/Http/Controllers/PetugasController.php

public function storeVerifikasi(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'hasil_verifikasi' => 'required',
        'catatan_verifikasi' => 'required',
    ]);

    $profil = ProfilPembudidaya::where('id_user', $request->id_user)->first();

    if ($profil) {
        // A. UPDATE STATUS IZIN USAHA (PENTING!)
        // Inilah yang membuat status "Proses" di tabel validasi-usaha-list berubah.
        DB::table('usaha_budidaya')
            ->where('id_profil_pembudidaya', $profil->id_profil_pembudidaya)
            ->update([
                'status_izin' => $request->hasil_verifikasi, // Nilai: disetujui/revisi/ditolak
                'updated_at' => now(),
            ]);

        // B. Update riwayat di tabel verifikasi
        DB::table('verifikasi')->insert([
            'id_profil_pembudidaya' => $profil->id_profil_pembudidaya,
            'id_profil_petugas'     => DB::table('profil_petugas_upt')->where('id_user', auth()->id())->value('id_profil_petugas') ?? 1,
            'status_verifikasi'     => $request->hasil_verifikasi,
            'catatan'               => $request->catatan_verifikasi,
            'tanggal_verifikasi'    => now(),
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }

    return back()->with('success', 'Status validasi berhasil diperbarui.');
}

// Pastikan nama fungsinya storeHasilVerifikasiDokumen (Sesuai web.php)
public function storeHasilVerifikasiDokumen(Request $request)
{
    $request->validate([
        'id_permohonan' => 'required|exists:permohonan_bantuans,id',
        'status' => 'required', // Sesuai name="status" di Blade Dokumen
        'catatan' => 'required'  // Sesuai name="catatan" di Blade Dokumen
    ]);

    $permohonan = PermohonanBantuan::findOrFail($request->id_permohonan);
    
    // Alur Akhir: Jika lolos dokumen, status jadi 'disetujui_admin' agar muncul di Penyaluran
    $permohonan->update([
        'status' => $request->status,
        'catatan_petugas' => $request->catatan,
        'updated_at' => now()
    ]);

    return redirect()->route('petugas.bantuan.dokumen.list')->with('success', 'Verifikasi dokumen selesai. Data siap disalurkan.');
}

    public function listValidasiUsaha()
{
    $pembudidaya = User::join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftjoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        ->where('users.role', 'pembudidaya')
        ->select(
            'users.id_user',
            'profil_pembudidaya.nama as nama_lengkap',
            'profil_pembudidaya.alamat', // Tambahkan ini
            'profil_pembudidaya.desa',   // Tambahkan ini
            'profil_pembudidaya.kecamatan', // Tambahkan ini
            'usaha_budidaya.jenis_ikan as komoditas',
            'usaha_budidaya.luas_kolam as luas_lahan',
            'usaha_budidaya.status_izin', 
            'usaha_budidaya.id_usaha'
        )
        ->paginate(10);

    return view('petugas.validasi-usaha-list', compact('pembudidaya'));
}

   public function listJadwalSurvei()
{
    $pembudidaya = User::join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->where('users.role', 'pembudidaya')
        ->select(
            'users.id_user', 
            'profil_pembudidaya.nama as nama_lengkap', 
            'profil_pembudidaya.alamat', 
            'profil_pembudidaya.desa',      // Tambahkan desa
            'profil_pembudidaya.kecamatan', // Tambahkan kecamatan
            'profil_pembudidaya.status_survei',
            'profil_pembudidaya.created_at'
        )
        ->paginate(10);

    return view('petugas.jadwal-survei-list', compact('pembudidaya'));
}

// Tambahkan fungsi baru untuk menyimpan jadwal
public function storeJadwalSurvei(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'tanggal_verifikasi' => 'required|date'
    ]);

    // GUNAKAN 'sudah' agar sinkron dengan Blade dan menghindari error 'Data Truncated'
    DB::table('profil_pembudidaya')
        ->where('id_user', $request->id_user)
        ->update([
            'status_survei' => 'sudah', 
            'updated_at' => now()
        ]);

    return back()->with('success', 'Jadwal verifikasi berhasil dibuat!');
}

    public function cancelJadwalSurvei(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
    ]);

    // Ganti null menjadi 'belum' untuk menghindari error constraint database
    DB::table('profil_pembudidaya')
        ->where('id_user', $request->id_user)
        ->update([
            'status_survei' => 'belum', // Nilai string agar tidak NULL
            'updated_at' => now()
        ]);

    return back()->with('success', 'Jadwal verifikasi berhasil dibatalkan.');
}
    // Tambahkan fungsi ini di PetugasController.php

public function verifikasiBantuan()
{
    $menunggu_kelayakan = PermohonanBantuan::where('status', 'pending')->count();
    $menunggu_dokumen = PermohonanBantuan::where('status', 'verifikasi_upt')->count();

    $permohonan = PermohonanBantuan::join('users', 'permohonan_bantuans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        ->select(
            'permohonan_bantuans.*',
            'profil_pembudidaya.nama as nama_pembudidaya',
            'profil_pembudidaya.alamat',
            'profil_pembudidaya.desa',
            'profil_pembudidaya.kecamatan',
            'profil_pembudidaya.status_survei',
            'usaha_budidaya.jenis_ikan as komoditas',
            'usaha_budidaya.luas_kolam'
        )
        ->latest('permohonan_bantuans.created_at')
        ->paginate(10);

    return view('petugas.verifikasi-bantuan', compact('menunggu_kelayakan', 'menunggu_dokumen', 'permohonan'));
}

    public function detailVerifikasiBantuan($id)
{
    $permohonan = PermohonanBantuan::join('users', 'permohonan_bantuans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        ->where('permohonan_bantuans.id', $id)
        ->select(
            'permohonan_bantuans.*',
            'profil_pembudidaya.nama as nama_pembudidaya',
            'profil_pembudidaya.desa',
            'profil_pembudidaya.kecamatan',
            'usaha_budidaya.jenis_ikan as komoditas',
            'usaha_budidaya.luas_kolam as skala_usaha'
        )
        ->firstOrFail();

    return view('petugas.verifikasi-bantuan-detail', compact('permohonan'));
}

    public function listKelayakanBantuan()
{
    // Mengambil data permohonan yang belum diproses (status pending)
    $permohonan = PermohonanBantuan::join('users', 'permohonan_bantuans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        ->where('permohonan_bantuans.status', 'pending')
        ->select(
            'permohonan_bantuans.*',
            'profil_pembudidaya.nama as nama_pembudidaya',
            'profil_pembudidaya.alamat',
            'profil_pembudidaya.desa',
            'profil_pembudidaya.kecamatan',
            'profil_pembudidaya.status_survei',
            'usaha_budidaya.jenis_ikan as komoditas',
            'usaha_budidaya.luas_kolam'
        )
        ->paginate(10);

    return view('petugas.verifikasi-bantuan-list', compact('permohonan'));
}

    public function storeKelayakanBantuan(Request $request)
{
    $request->validate([
        'id_permohonan' => 'required|exists:permohonan_bantuans,id',
        'hasil_kelayakan' => 'required',
        'catatan_kelayakan' => 'required'
    ]);

    $permohonan = PermohonanBantuan::findOrFail($request->id_permohonan);
    
    // Logika Alur: Jika disetujui di lapangan, status jadi 'verifikasi_upt' (masuk ke cek dokumen)
    $status = ($request->hasil_kelayakan == 'disetujui') ? 'verifikasi_upt' : $request->hasil_kelayakan;

    $permohonan->update([
        'status' => $status,
        'catatan_petugas' => $request->catatan_kelayakan,
        'updated_at' => now()
    ]);

    // Redirect ke list bantuan (pending) karena data ini sudah pindah ke list dokumen
    return redirect()->route('petugas.bantuan.list')->with('success', 'Verifikasi kelayakan berhasil. Data diteruskan ke bagian dokumen.');
}

    // Tampilkan Daftar Dokumen (image_9603bc.png)
public function listVerifikasiDokumen()
{
    $permohonan = PermohonanBantuan::join('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        ->where('permohonan_bantuans.status', 'verifikasi_upt') // Mengambil data yang lolos verifikasi kelayakan
        ->select('permohonan_bantuans.*', 'profil_pembudidaya.nama as nama_pembudidaya', 'profil_pembudidaya.status_survei')
        ->paginate(10);

    return view('petugas.verifikasi-bantuan-dokumen-list', compact('permohonan'));
}

// Tampilkan Detail Dokumen (image_952225.png)
public function detailVerifikasiDokumen($id)
{
    $permohonan = PermohonanBantuan::join('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('usaha_budidaya', 'profil_pembudidaya.id_profil_pembudidaya', '=', 'usaha_budidaya.id_profil_pembudidaya')
        ->where('permohonan_bantuans.id', $id)
        ->select(
            'permohonan_bantuans.*', 
            'profil_pembudidaya.nama as nama_pembudidaya',
            'profil_pembudidaya.desa',
            'profil_pembudidaya.kecamatan',
            'usaha_budidaya.jenis_ikan as komoditas',
            'usaha_budidaya.luas_kolam'
        )
        ->firstOrFail();

    return view('petugas.verifikasi-bantuan-dokumen-detail', compact('permohonan'));
}

public function storeVerifikasiDokumen(Request $request)
{
    $request->validate([
        'id_permohonan' => 'required|exists:permohonan_bantuans,id',
        'status' => 'required', // disetujui_admin / revisi
        'catatan' => 'required'
    ]);

    $permohonan = PermohonanBantuan::findOrFail($request->id_permohonan);
    $permohonan->update([
        'status' => $request->status,
        'catatan_petugas' => $request->catatan,
        'updated_at' => now()
    ]);

    return redirect()->route('petugas.bantuan.dokumen.list')->with('success', 'Verifikasi dokumen selesai.');
}


    // Tambahkan/Update fungsi ini di PetugasController.php

// Update fungsi di PetugasController.php

public function storePenyaluran(Request $request)
{
    $request->validate([
        'id_permohonan' => 'required|exists:permohonan_bantuans,id',
        'tanggal_penyaluran' => 'required|date',
    ]);

    $permohonan = PermohonanBantuan::findOrFail($request->id_permohonan);
    
    // Update kolom tanggal_diterima dan status menjadi 'dikirim'
    $permohonan->update([
        'tanggal_diterima' => $request->tanggal_penyaluran,
        'status' => 'dikirim' 
    ]);

    return back()->with('success', 'Data distribusi berhasil disimpan! Status: Dikirim.');
}

public function uploadBAST(Request $request)
{
    $request->validate([
        'id_permohonan' => 'required|exists:permohonan_bantuans,id',
        'file_bast' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Validasi foto bukti
    ]);

    $permohonan = PermohonanBantuan::findOrFail($request->id_permohonan);

    if ($request->hasFile('file_bast')) {
        // Simpan file ke storage public
        $path = $request->file('file_bast')->store('bukti_terima', 'public');
        
        // Simpan ke kolom foto_bukti_terima dan ubah status menjadi 'selesai'
        $permohonan->update([
            'foto_bukti_terima' => $path,
            'status' => 'selesai'
        ]);
    }

    return back()->with('success', 'BAST Berhasil diunggah! Status Permohonan: Selesai.');
}

   public function penyaluranIndex()
{
    // 1. Data untuk Form Distribusi
    // Gunakan leftJoin agar data tetap muncul meskipun profil belum sempurna
    $penerima = PermohonanBantuan::leftJoin('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        // Pastikan status ini SAMA dengan nilai (value) yang ada di <option> View Detail Dokumen
        ->whereIn('permohonan_bantuans.status', ['disetujui_admin', 'direkomendasikan']) 
        ->select(
            'permohonan_bantuans.id', 
            'profil_pembudidaya.nama', 
            'permohonan_bantuans.jenis_bantuan',
            'permohonan_bantuans.id_user' // Tambahan untuk tracking
        )
        ->get();

    // 2. Data untuk Form BAST
    $penerima_bast = PermohonanBantuan::leftJoin('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        ->where('permohonan_bantuans.status', 'dikirim')
        ->select('permohonan_bantuans.id', 'profil_pembudidaya.nama', 'permohonan_bantuans.jenis_bantuan')
        ->get();

    return view('petugas.penyaluran', compact('penerima', 'penerima_bast'));
}
       // Update fungsi di PetugasController.php

public function monitoringIndex()
{
    // Pastikan status adalah 'selesai'
    $monitoring = PermohonanBantuan::join('users', 'permohonan_bantuans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->where('permohonan_bantuans.status', 'selesai') 
        ->select(
            'permohonan_bantuans.id',
            'permohonan_bantuans.jenis_bantuan',
            'permohonan_bantuans.detail_kebutuhan',
            'permohonan_bantuans.tanggal_diterima',
            'permohonan_bantuans.tanggal_monitoring_terakhir', // Tambahkan ini
            'profil_pembudidaya.nama as nama_penerima'
        )
        ->latest('permohonan_bantuans.updated_at')
        ->paginate(10);

    return view('petugas.monitoring', compact('monitoring'));
}

// Fungsi baru untuk menyimpan jadwal monitoring
public function storeJadwalMonitoring(Request $request)
{
    $request->validate([
        'id' => 'required|exists:permohonan_bantuans,id',
        'tanggal_monitoring' => 'required|date'
    ]);

    PermohonanBantuan::where('id', $request->id)->update([
        'tanggal_monitoring_terakhir' => $request->tanggal_monitoring,
        'updated_at' => now()
    ]);

    return back()->with('success', 'Jadwal monitoring berhasil diperbarui.');
}

    public function daftarPendampingan()
{
    $pendampingan = PengajuanPendampingan::join('users', 'pengajuan_pendampingans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->select(
            'pengajuan_pendampingans.*',
            'profil_pembudidaya.nama as nama_pembudidaya'
        )
        ->latest('pengajuan_pendampingans.created_at')
        ->paginate(10);

    return view('petugas.pendampingan-list', compact('pendampingan'));
}

public function detailPendampingan($id)
{
    $detail = PengajuanPendampingan::join('users', 'pengajuan_pendampingans.id_user', '=', 'users.id_user')
        ->join('profil_pembudidaya', 'users.id_user', '=', 'profil_pembudidaya.id_user')
        ->select(
            'pengajuan_pendampingans.*',
            'profil_pembudidaya.nama as nama_pembudidaya',
            'profil_pembudidaya.desa',
            'profil_pembudidaya.kecamatan'
        )
        ->where('pengajuan_pendampingans.id', $id)
        ->firstOrFail();

    return view('petugas.pendampingan-detail', compact('detail'));
}
// Tambahkan fungsi ini di PetugasController.php
public function storeJadwalPendampingan(Request $request)
{
    $request->validate([
        'id' => 'required|exists:pengajuan_pendampingans,id',
        'jadwal_pendampingan' => 'required|date'
    ]);

    DB::table('pengajuan_pendampingans')
        ->where('id', $request->id)
        ->update([
            'jadwal_pendampingan' => $request->jadwal_pendampingan,
            'status' => 'dijadwalkan', // Ubah status agar pindah ke tahap berikutnya
            'updated_at' => now()
        ]);

    return back()->with('success', 'Jadwal pendampingan berhasil dibuat.');
}

    public function inputHasilPendampingan()
{
    // Mengambil pendampingan yang sudah terjadwal untuk dilaporkan hasilnya
    $list_pendampingan = PengajuanPendampingan::join('profil_pembudidaya', 'pengajuan_pendampingans.id_user', '=', 'profil_pembudidaya.id_user')
        ->where('pengajuan_pendampingans.status', 'dijadwalkan')
        ->select('pengajuan_pendampingans.id', 'profil_pembudidaya.nama', 'pengajuan_pendampingans.topik')
        ->get();

    return view('petugas.pendampingan-input', compact('list_pendampingan'));
}

    public function storeHasilPendampingan(Request $request)
    {
        $request->validate([
            'id_pendampingan' => 'required',
            'hasil_pendampingan' => 'required',
            'file_dokumentasi' => 'required|image|max:5120',
            'rekomendasi' => 'required',
        ]);

        $item = PengajuanPendampingan::findOrFail($request->id_pendampingan);
        $path = $request->file('file_dokumentasi')->store('dokumentasi_pendampingan', 'public');

        $item->update([
            'hasil_pendampingan' => $request->hasil_pendampingan,
            'file_dokumentasi' => $path,
            'rekomendasi_tindak_lanjut' => $request->rekomendasi,
            'status' => 'selesai' // Ubah status menjadi selesai
        ]);

        return back()->with('success', 'Laporan pendampingan berhasil disimpan!');
    }
    }