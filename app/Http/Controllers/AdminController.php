<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Komoditas;
use App\Models\WilayahAdmin;
use App\Models\JenisBantuanAdmin;
use App\Models\TopikPendampingAdmin;
use App\Models\PermohonanBantuan;
use App\Models\PengajuanPendampingan;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil data untuk Card Statistik
        $stats = [
            'total_pembudidaya' => User::where('role', 'pembudidaya')->count(),
            'bantuan_disalurkan' => PermohonanBantuan::where('status', 'selesai')->count(),
            'permohonan_pending' => PermohonanBantuan::where('status', 'pending')->count(),
            'pendampingan_ini' => PengajuanPendampingan::whereMonth('created_at', now()->month)->count(),
        ];

        // 2. Data Sebaran Wilayah (image_65b1e8.png)
        // Menghitung total per kecamatan vs yang sudah verifikasi lapangan (status_survei = sudah)
        $wilayah = DB::table('profil_pembudidaya')
            ->select('kecamatan', 
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status_survei = "sudah" then 1 else 0 end) as terverifikasi'))
            ->groupBy('kecamatan')
            ->get();

        return view('admin.dashboard', compact('stats', 'wilayah'));
    }

    public function komoditasIndex(Request $request)
{
    $query = DB::table('master_komoditas');

    // Fitur Cari Komoditas (image_6782e4.png)
    if ($request->has('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    $komoditas = $query->paginate(10);

    return view('admin.master.komoditas', compact('komoditas'));
}

    public function komoditasStore(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'nama' => 'required|string|max:255|unique:master_komoditas,nama',
    ]);

    // 2. Simpan ke database menggunakan Model Komoditas
    Komoditas::create([
        'nama' => $request->nama,
        'status' => 'Aktif' // Default status aktif sesuai gambar tabel
    ]);

    // 3. Kembali ke halaman sebelumnya dengan pesan sukses
    return back()->with('success_crud', 'Komoditas baru berhasil ditambahkan!');
}

    public function komoditasUpdate(Request $request, $id)
{
    // 1. Validasi input
    $request->validate([
        // Pastikan nama unik, tapi abaikan untuk ID yang sedang diedit ini
        'nama' => 'required|string|max:255|unique:master_komoditas,nama,' . $id,
    ]);

    // 2. Cari data berdasarkan ID
    $komoditas = Komoditas::findOrFail($id);

    // 3. Update data
    $komoditas->update([
        'nama' => $request->nama,
    ]);

    // 4. Kembali dengan pesan sukses
    return back()->with('success_crud', 'Data komoditas berhasil diperbarui!');
}

    public function komoditasDestroy($id)
    {
        // 1. Cari data komoditas berdasarkan ID yang dikirim dari form
        // Jika ID tidak ditemukan, Laravel akan otomatis menampilkan error 404.
        $komoditas = Komoditas::findOrFail($id);

        // 2. Jalankan fungsi hapus
        $komoditas->delete();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        // Pesan ini akan muncul di bagian atas tabel jika Anda sudah memasang alert success.
        return back()->with('success_crud', 'Data komoditas "' . $komoditas->nama . '" berhasil dihapus!');
    }

    public function wilayahIndex(Request $request)
{
    $query = WilayahAdmin::query();
    
    // Fitur cari nama wilayah (image_7431ca.png)
    if ($request->has('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }
    
    $wilayah = $query->paginate(10);
    return view('admin.master.wilayah', compact('wilayah'));
}

public function wilayahStore(Request $request)
{
    $request->validate(['nama' => 'required|string|max:255|unique:master_wilayah,nama']);
    
    WilayahAdmin::create([
        'nama' => $request->nama,
        'status' => 'Aktif'
    ]);

    return back()->with('success_crud', 'Data Berhasil Disimpan'); // Memicu pop-up sukses
}

public function wilayahUpdate(Request $request, $id)
{
    $request->validate(['nama' => 'required|string|max:255|unique:master_wilayah,nama,'.$id]);
    
    WilayahAdmin::findOrFail($id)->update(['nama' => $request->nama]);
    
    return back()->with('success_crud', 'Data Berhasil Diperbarui');
}

public function wilayahDestroy($id)
{
    WilayahAdmin::findOrFail($id)->delete();
    return back()->with('success_crud', 'Data Berhasil Dihapus');
}

public function jenisBantuanIndex(Request $request)
{
    $query = JenisBantuanAdmin::query();
    if ($request->has('search')) {
        $query->where('nama_bantuan', 'like', '%' . $request->search . '%')
              ->orWhere('kategori', 'like', '%' . $request->search . '%');
    }
    $bantuan = $query->paginate(10);
    return view('admin.master.jenis-bantuan', compact('bantuan'));
}

public function jenisBantuanStore(Request $request)
{
    $request->validate([
        'nama_bantuan' => 'required|string|max:255',
        'kategori' => 'required|string|max:255'
    ]);

    JenisBantuanAdmin::create([
        'nama_bantuan' => $request->nama_bantuan,
        'kategori' => $request->kategori,
        'status' => 'Aktif'
    ]);

    return back()->with('success_crud', 'Data Berhasil Disimpan');
}

public function jenisBantuanUpdate(Request $request, $id)
{
    $request->validate([
        'nama_bantuan' => 'required|string|max:255',
        'kategori' => 'required|string|max:255'
    ]);

    JenisBantuanAdmin::findOrFail($id)->update([
        'nama_bantuan' => $request->nama_bantuan,
        'kategori' => $request->kategori
    ]);

    return back()->with('success_crud', 'Data Berhasil Diperbarui');
}

public function jenisBantuanDestroy($id)
{
    JenisBantuanAdmin::findOrFail($id)->delete();
    return back()->with('success_crud', 'Data Berhasil Dihapus');
}

public function topikIndex(Request $request)
{
    $query = TopikPendampingAdmin::query();
    if ($request->has('search')) {
        $query->where('nama_topik', 'like', '%' . $request->search . '%')
              ->orWhere('kategori', 'like', '%' . $request->search . '%');
    }
    $topik = $query->paginate(10);
    return view('admin.master.topik-pendamping', compact('topik'));
}

public function topikStore(Request $request)
{
    $request->validate([
        'nama_topik' => 'required|string|max:255',
        'kategori' => 'required|string|max:255',
        'deskripsi' => 'required'
    ]);

    TopikPendampingAdmin::create($request->all());

    return back()->with('success_crud', 'Data Berhasil Disimpan');
}

public function topikUpdate(Request $request, $id)
{
    $request->validate([
        'nama_topik' => 'required|string|max:255',
        'kategori' => 'required|string|max:255',
        'deskripsi' => 'required'
    ]);

    TopikPendampingAdmin::findOrFail($id)->update($request->all());
    return back()->with('success_crud', 'Data Berhasil Diperbarui');
}

public function topikDestroy($id)
{
    TopikPendampingAdmin::findOrFail($id)->delete();
    return back()->with('success_crud', 'Data Berhasil Dihapus');
}

public function permohonanIndex(Request $request)
{
    // 1. Statistik untuk Kartu Atas
    $stats = [
        'total' => PermohonanBantuan::count(),
        'disetujui' => PermohonanBantuan::where('status', 'selesai')->count(),
        'ditolak' => PermohonanBantuan::where('status', 'ditolak')->count(),
        'menunggu' => PermohonanBantuan::whereIn('status', ['pending', 'verifikasi_upt', 'disetujui_admin'])->count(),
    ];

    // 2. Ambil Data Tabel dengan Join
    $query = PermohonanBantuan::join('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        ->select(
            'permohonan_bantuans.*',
            'profil_pembudidaya.nama as nama_pemohon',
            'profil_pembudidaya.desa as lokasi'
        );

    // Pencarian
    if ($request->has('search')) {
        $query->where('profil_pembudidaya.nama', 'like', '%' . $request->search . '%');
    }

    $permohonan = $query->latest()->paginate(10);

    return view('admin.permohonan.index', compact('stats', 'permohonan'));
}

    public function getDetailData($id)
{
    // Ambil data bantuan beserta profil pembudidaya
    $data = PermohonanBantuan::join('profil_pembudidaya', 'permohonan_bantuans.id_user', '=', 'profil_pembudidaya.id_user')
        ->select(
            'permohonan_bantuans.*', 
            'profil_pembudidaya.nama as nama_pemohon'
        )
        ->where('permohonan_bantuans.id', $id)
        ->first();

    if (!$data) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    return response()->json($data);
}

    public function permohonanUpdateVerifikasi(Request $request, $id)
{
    $request->validate([
        'skala_prioritas' => 'required',
        'catatan_petugas' => 'required',
        'status' => 'required' // 'selesai' untuk Disetujui atau 'ditolak'
    ]);

    $permohonan = PermohonanBantuan::findOrFail($id);
    
    $permohonan->update([
        'skala_prioritas' => $request->skala_prioritas,
        'catatan_petugas' => $request->catatan_petugas,
        'status' => $request->status,
        'updated_at' => now()
    ]);

    return back()->with('success_crud', 'Hasil Verifikasi Berhasil Disimpan');
}

    public function permohonanDestroy($id)
{
    // 1. Cari data permohonan
    $permohonan = PermohonanBantuan::findOrFail($id);

    // 2. Hapus data dari database
    $permohonan->delete();

    // 3. Kembali dengan pesan sukses untuk memicu pop-up
    return back()->with('success_crud', 'Data Permohonan Berhasil Dihapus');
}
public function pendampinganIndex(Request $request)
{
    $tab = $request->get('tab', 'monitoring');

    // 1. Statistik Kartu Atas (image_8241ae.png)
    $stats = [
        'total' => PengajuanPendampingan::count(),
        'selesai' => PengajuanPendampingan::where('status', 'selesai')->count(),
        'berjalan' => PengajuanPendampingan::where('status', 'sedang_berjalan')->count(),
        'menunggu' => PengajuanPendampingan::where('status', 'dijadwalkan')->count(),
    ];

    if ($tab == 'rekap') {
        // 2. Data Rekap Topik (image_8241ae.png)
        $topikStats = DB::table('pengajuan_pendampingans')
            ->join('master_topik_pendamping', 'pengajuan_pendampingans.id_topik', '=', 'master_topik_pendamping.id')
            ->select('master_topik_pendamping.nama_topik', DB::raw('count(*) as total'))
            ->groupBy('master_topik_pendamping.nama_topik')
            ->get();

        // 3. Data Rekap Wilayah (image_8241ae.png)
        $wilayahStats = DB::table('pengajuan_pendampingans')
            ->join('profil_pembudidaya', 'pengajuan_pendampingans.id_user', '=', 'profil_pembudidaya.id_user')
            ->select('profil_pembudidaya.desa as wilayah', DB::raw('count(*) as total'))
            ->groupBy('profil_pembudidaya.desa')
            ->get();

        return view('admin.pendampingan.index', compact('stats', 'topikStats', 'wilayahStats', 'tab'));
    }

    // Logika Monitoring Pelaksana (Data Tabel)
    $pendampingan = PengajuanPendampingan::leftJoin('users as petugas', 'pengajuan_pendampingans.id_petugas', '=', 'petugas.id_user')
        ->leftJoin('profil_pembudidaya', 'pengajuan_pendampingans.id_user', '=', 'profil_pembudidaya.id_user')
        ->leftJoin('master_topik_pendamping', 'pengajuan_pendampingans.id_topik', '=', 'master_topik_pendamping.id')
        ->select('pengajuan_pendampingans.*', 'petugas.nama_lengkap as nama_petugas', 'profil_pembudidaya.nama as nama_pembudidaya', 'master_topik_pendamping.nama_topik')
        ->latest()->paginate(10);

    return view('admin.pendampingan.index', compact('stats', 'pendampingan', 'tab'));
}

    public function laporanIndex()
{
    $now = Carbon::now();

    // 1. Ringkasan Bulanan
    $ringkasan = [
        'pendaftar_baru' => User::where('role', 'pembudidaya')
                            ->whereMonth('created_at', $now->month)->count(),
        'verifikasi_selesai' => DB::table('permohonan_bantuans')
                            ->where('status', '!=', 'pending')
                            ->whereMonth('updated_at', $now->month)->count(),
        'tingkat_approval' => 94.4, // Ini bisa dihitung dari rasio disetujui/total
    ];

    // 2. Top Komoditas Bulan Ini (Contoh data statis sesuai image_824da3.png)
    $topKomoditas = [
        ['nama' => 'Lele', 'jumlah' => 320],
        ['nama' => 'Nila', 'jumlah' => 245],
        ['nama' => 'Udang', 'jumlah' => 189],
    ];

    return view('admin.laporan.index', compact('ringkasan', 'topKomoditas'));
}
}
