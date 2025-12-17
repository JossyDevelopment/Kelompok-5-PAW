<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PermohonanBantuan;
use App\Models\PengajuanPendampingan;
use Carbon\Carbon;

class PembudidayaController extends Controller
{
    // ==========================================================
    // 1. DASHBOARD
    // ==========================================================
    public function dashboard()
    {
        $id_user = Auth::user()->id_user;

        $total_permohonan = PermohonanBantuan::where('id_user', $id_user)->count();
        
        $pendampingan_selesai = PengajuanPendampingan::where('id_user', $id_user)
                                ->where('status', 'selesai')->count();

        // Data Dummy untuk nilai bantuan (karena belum ada tabel anggaran)
        $total_bantuan = 0; 

        // Cek kelengkapan profil user
        $user = Auth::user();
        $status_verifikasi = ($user->nik && $user->alamat) ? 'Lengkap' : 'Belum Lengkap';
        $bantuan = PermohonanBantuan::where('id_user', $id_user)
                ->select('jenis_bantuan as title', 'created_at', 'status')
                ->get()
                ->map(function($item) {
                    $item->type = 'Bantuan';
                    $item->description = 'Pengajuan Bantuan: ' . ucfirst($item->title);
                    return $item;
                });

    // 2. Ambil Pendampingan
    $pendampingan = PengajuanPendampingan::where('id_user', $id_user)
                ->select('topik as title', 'created_at', 'status')
                ->get()
                ->map(function($item) {
                    $item->type = 'Pendampingan';
                    $item->description = 'Permohonan Pendampingan: ' . $item->title;
                    return $item;
                });

    // 3. Gabung (Merge) dan Urutkan dari yang terbaru
    $timeline_activities = $bantuan->concat($pendampingan)->sortByDesc('created_at')->take(5);

        // Timeline: Mengambil 5 data terbaru dari tabel Permohonan
        $timeline_activities = PermohonanBantuan::where('id_user', $id_user)
                                ->latest()
                                ->take(5)
                                ->get()
                                ->map(function($item) {
                                    // Format data agar sesuai tampilan blade
                                    return [
                                        'title' => 'Permohonan: ' . ucfirst($item->jenis_bantuan),
                                        'date'  => $item->created_at->diffForHumans(),
                                        'description' => 'Status saat ini: ' . ucfirst(str_replace('_', ' ', $item->status)),
                                        'status' => ($item->status == 'selesai') ? 'done' : 'current'
                                    ];
                                });

        return view('pembudidaya.dashboard', compact(
            'total_permohonan', 'pendampingan_selesai', 'status_verifikasi', 'total_bantuan', 'timeline_activities'
        ));
    }

    // ==========================================================
    // 2. PROFIL
    // ==========================================================
    public function profil() {
        return view('pembudidaya.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request)
    {
        $rules = [];
        
        // LOGIKA Validasi Dinamis
        // Jika yang dikirim adalah Form Data Diri (ada field nama_lengkap)
        if ($request->has('nama_lengkap')) {
            $rules = [
                'nama_lengkap' => 'required|string',
                'nik' => 'required|numeric|digits:16',
                'nomor_hp' => 'required',
                'alamat' => 'nullable|string',
            ];
        } 
        // Jika yang dikirim adalah Form Detail Usaha (ada field komoditas)
        elseif ($request->has('komoditas')) {
            $rules = [
                'komoditas' => 'required',
                'luas_lahan' => 'nullable|numeric',
                'sistem_budidaya' => 'nullable|string',
            ];
        }

        // Jalankan Validasi
        $request->validate($rules);

        // Simpan Data
        $user = User::find(Auth::user()->id_user);
        $user->update($request->except(['_token']));

        return back()->with('success', 'Data Berhasil Disimpan');
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