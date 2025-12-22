<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PermohonanBantuan;
use App\Models\PengajuanPendampingan;
use App\Models\ProfilPembudidaya;
use App\Models\wilayah;
use App\Models\UsahaBudidaya;
use Carbon\Carbon;

class PembudidayaController extends Controller
{
    // ==========================================================
    // 1. DASHBOARD
    // ==========================================================
    public function dashboard()
    {
        $id_user = Auth::user()->id_user;

        // Statistik Riil
        $total_permohonan = PermohonanBantuan::where('id_user', $id_user)->count();
        $pendampingan_selesai = PengajuanPendampingan::where('id_user', $id_user)
                                ->where('status', 'selesai')->count();
        $total_bantuan = 0; 

        // FIX: Cek kelengkapan ke tabel profil_pembudidaya (bukan tabel users)
        $profil = ProfilPembudidaya::where('id_user', $id_user)->first();
        // Cek NIK (huruf besar sesuai migration) dan alamat
        $status_verifikasi = ($profil && $profil->NIK && $profil->alamat) ? 'Lengkap' : 'Belum Lengkap';

        // 1. Ambil data Bantuan untuk Timeline
        $bantuan = PermohonanBantuan::where('id_user', $id_user)
                ->select('jenis_bantuan as title', 'created_at', 'status')
                ->get()
                ->map(function($item) {
                    return [
                        'title' => 'Bantuan: ' . ucfirst($item->title),
                        'date'  => $item->created_at->diffForHumans(),
                        'description' => 'Status: ' . ucfirst(str_replace('_', ' ', $item->status)),
                        'status' => ($item->status == 'selesai') ? 'done' : 'current'
                    ];
                });

        // 2. Ambil data Pendampingan untuk Timeline
        $pendampingan = PengajuanPendampingan::where('id_user', $id_user)
                ->select('topik as title', 'created_at', 'status')
                ->get()
                ->map(function($item) {
                    return [
                        'title' => 'Pendampingan: ' . $item->title,
                        'date'  => $item->created_at->diffForHumans(),
                        'description' => 'Status: ' . ucfirst($item->status),
                        'status' => ($item->status == 'selesai') ? 'done' : 'current'
                    ];
                });

        // 3. Gabungkan dan Urutkan (Hapus baris yang menimpa variabel di bawahnya)
        $timeline_activities = $bantuan->concat($pendampingan)->sortByDesc('date')->take(5);

        return view('pembudidaya.dashboard', compact(
            'total_permohonan', 'pendampingan_selesai', 'status_verifikasi', 'total_bantuan', 'timeline_activities'
        ));
    }

    // ==========================================================
    // 2. PROFIL
    // ==========================================================
    public function profil() {
        // Ambil user beserta profilnya
        $user = Auth::user();
        $profil = ProfilPembudidaya::where('id_user', $user->id_user)->first();
        return view('pembudidaya.profil', compact('user', 'profil'));
    }
    

    public function updateProfil(Request $request)
{
    $id_user = Auth::user()->id_user;
    
    // Ambil data profil yang sudah ada atau siapkan variabel null
    $profil = ProfilPembudidaya::where('id_user', $id_user)->first();

    // --- BAGIAN 1: UPDATE DATA DIRI (Hanya jika input 'nama' ada) ---
    if ($request->has('nama')) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'NIK' => 'required|numeric|digits:16',
            'nomor_hp' => 'required',
            'alamat' => 'required|string',
        ]);

        $profil = ProfilPembudidaya::updateOrCreate(
            ['id_user' => $id_user], 
            [
                'nama' => $request->nama,
                'NIK'  => $request->NIK,
                'alamat' => $request->alamat,
                'nomor_hp' => $request->nomor_hp,
                'kecamatan' => $request->kecamatan ?? '-',
                'desa' => $request->desa ?? '-',
                'tipe_pembudidaya' => 'Perorangan',
            ]
        );
    }

    // --- BAGIAN 2: UPDATE DETAIL USAHA (Hanya jika input 'jenis_ikan' ada) ---
    if ($request->has('jenis_ikan')) {
        $request->validate([
            'jenis_ikan' => 'required',
            'luas_kolam' => 'required|numeric',
            'tipe_kolam' => 'required',
        ]);

        // Pastikan profil sudah ada sebelum membuat detail usaha
        if (!$profil) {
            $profil = ProfilPembudidaya::updateOrCreate(['id_user' => $id_user], [
                'nama' => Auth::user()->nama_lengkap,
                'nomor_hp' => Auth::user()->nomor_hp,
            ]);
        }

        UsahaBudidaya::updateOrCreate(
            ['id_profil_pembudidaya' => $profil->id_profil_pembudidaya],
            [
                'jenis_ikan' => $request->jenis_ikan,
                'luas_kolam' => $request->luas_kolam,
                'tipe_kolam'  => $request->tipe_kolam,
                'jumlah_kolam' => 1,
                'kapasitas_produksi' => '0'
            ]
        );
    }

    return back()->with('success', 'Data Berhasil Diperbarui');
}
    // ==========================================================
    // 3. AJUKAN BANTUAN
    // ==========================================================
    public function ajukanBantuan() {
        return view('pembudidaya.ajukan');
    }

    public function storeBantuan(Request $request) {
        $request->validate([
            'jenis_bantuan' => 'required',
            'detail_kebutuhan' => 'required',
            'file_permohonan' => 'required|mimes:pdf|max:5120', // Max 5MB
            'file_legalitas' => 'required|mimes:pdf,jpg,jpeg|max:5120',
        ]);

        $path1 = $request->file('file_permohonan')->store('dokumen', 'public');
        $path2 = $request->file('file_legalitas')->store('dokumen', 'public');

        PermohonanBantuan::create([
            'id_user' => Auth::user()->id_user,
            'no_tiket' => 'PB-' . date('ymd') . '-' . rand(100, 999),
            'jenis_bantuan' => $request->jenis_bantuan,
            'detail_kebutuhan' => $request->detail_kebutuhan,
            'file_proposal' => $path1,
            'file_legalitas' => $path2,
            'status' => 'pending'
        ]);

        return redirect()->route('pembudidaya.status')->with('success', 'Permohonan Berhasil Dikirim!');
    }

    // ==========================================================
    // 4. STATUS & LACAK
    // ==========================================================
    public function statusLacak() {
        $permohonan = PermohonanBantuan::where('id_user', Auth::user()->id_user)
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return view('pembudidaya.status', compact('permohonan'));
    }

    // ==========================================================
    // 5. PENERIMAAN (KONFIRMASI)
    // ==========================================================
    public function penerimaan() {
        // Hanya ambil yang statusnya 'dikirim' (siap konfirmasi) atau 'selesai' (sudah dikonfirmasi)
        $daftar_bantuan = PermohonanBantuan::where('id_user', Auth::user()->id_user)
                            ->whereIn('status', ['dikirim', 'selesai'])
                            ->orderBy('updated_at', 'desc')
                            ->get();

        return view('pembudidaya.penerimaan', compact('daftar_bantuan'));
    }

    public function storeKonfirmasi(Request $request) {
        $request->validate([
            'kode_tiket' => 'required',
            'tanggal_terima' => 'required|date',
            'foto_bukti' => 'required|image|max:5120'
        ]);

        $bantuan = PermohonanBantuan::where('no_tiket', $request->kode_tiket)->firstOrFail();
        $path = $request->file('foto_bukti')->store('bukti_terima', 'public');

        $bantuan->update([
            'status' => 'selesai',
            'tanggal_diterima' => $request->tanggal_terima,
            'catatan_penerimaan' => $request->catatan,
            'foto_bukti_terima' => $path
        ]);

        return back()->with('success', 'Konfirmasi Penerimaan Berhasil!');
    }

    // ==========================================================
    // 6. PENDAMPINGAN TEKNIS (Ajukan & Feedback)
    // ==========================================================
    public function ajukanPendampingan() {
        return view('pembudidaya.pendampingan-ajukan');
    }

    public function storePendampingan(Request $request) {
        $request->validate([
            'topik_pendampingan' => 'required',
            'detail_kebutuhan' => 'required',
        ]);

        PengajuanPendampingan::create([
            'id_user' => Auth::user()->id_user,
            'topik' => $request->topik_pendampingan,
            'detail_keluhan' => $request->detail_kebutuhan,
            'status' => 'pending'
        ]);

        return redirect()->route('pembudidaya.pendampingan.jadwal')->with('success', 'Pengajuan Pendampingan Terkirim!');
    }

    public function jadwalFeedback() {
        $id_user = Auth::user()->id_user;

        // Jadwal Mendatang (Status: dijadwalkan)
        // Logikanya: Tanggal jadwal belum lewat
        $jadwal_mendatang = PengajuanPendampingan::where('id_user', $id_user)
            ->where('status', 'dijadwalkan')
            ->orderBy('jadwal_pendampingan', 'asc')
            ->get();

        // List Feedback (Status: selesai, atau bisa juga 'dijadwalkan' tapi tanggal sudah lewat)
        // Disini kita ambil semua history untuk ditampilkan di tab feedback
        $list_feedback = PengajuanPendampingan::where('id_user', $id_user)
            ->whereIn('status', ['selesai', 'dijadwalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembudidaya.pendampingan-jadwal', compact('jadwal_mendatang', 'list_feedback'));
    }

    public function storeFeedback(Request $request) {
        $request->validate([
            'id_pendampingan' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required'
        ]);

        $item = PengajuanPendampingan::find($request->id_pendampingan);
        
        if($item) {
            $item->update([
                'rating' => $request->rating,
                'ulasan_feedback' => $request->ulasan,
                'status' => 'selesai' // Pastikan status jadi selesai
            ]);
        }

        return back()->with('success', 'Terima Kasih atas Feedback Anda!');
    }
}