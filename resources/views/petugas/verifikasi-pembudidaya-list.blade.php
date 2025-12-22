@extends('layouts.petugas')

@section('title', 'Verifikasi Pembudidaya')
@section('subtitle', 'Verifikasi Data dan Usaha Budidaya')

@section('content')
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800">Daftar Pembudidaya Menunggu Verifikasi Data</h3>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('petugas.verifikasi') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Ringkasan Tugas
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative w-full md:w-96">
                <input type="text" placeholder="Cari Permohonan" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 bg-gray-50/50">
            </div>
            <button class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-green-800 transition">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-6">Nama</th>
                    <th class="p-6">KTP (4 Digit Akhir)</th>
                    <th class="p-6">Tanggal Pengajuan</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pembudidaya as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $user->nama_lengkap }}</td>
                    <td class="p-6 text-sm text-gray-500">
                        @if($user->NIK)
                            ...{{ substr($user->NIK, -4) }}
                        @else
                            <span class="text-red-400 italic">Belum Melengkapi Profil</span>
                        @endif
                    </td>
                    <td class="p-6 text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="p-6">
                    @if($user->status_verifikasi == 'disetujui')
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg border border-green-200 uppercase">Disetujui</span>
                    @elseif($user->status_verifikasi == 'revisi')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-bold rounded-lg border border-orange-200 uppercase">Revisi</span>
                    @elseif($user->status_verifikasi == 'ditolak')
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg border border-red-200 uppercase">Ditolak</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-lg border border-yellow-200 uppercase">Baru</span>
                    @endif
                </td>
                    <td class="p-6">
                        <button 
                            onclick="openVerificationModal('{{ $user->id_user }}', '{{ $user->nama_lengkap }}', '{{ $user->luas_lahan ?? 0 }}', '{{ $user->jumlah_kolam ?? 0 }}')"
                            class="text-sm font-bold text-green-700 hover:text-green-900 transition">
                            Verifikasi Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">Tidak ada data pembudidaya yang menunggu verifikasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-6 bg-white border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-500">Menampilkan 1 - {{ $pembudidaya->count() }} dari {{ $pembudidaya->total() }} Data</p>
        <div class="flex items-center gap-2">
            {{ $pembudidaya->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<div id="verificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all">
            
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Form Verifikasi Pembudidaya</h3>
                <p id="modalUserName" class="text-sm text-gray-500"></p>
            </div>

            <form action="{{ route('petugas.verifikasi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_user" id="modalUserId">

                <div class="px-8 py-6 space-y-5 max-h-[70vh] overflow-y-auto">
                    
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="lokasi_sesuai" id="lokasi" class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500">
                        <label for="lokasi" class="text-sm font-medium text-gray-700">Lokasi sesuai dengan data yang diajukan</label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Luas Lahan Aktual (m²)</label>
                        <input type="number" name="luas_lahan_aktual" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: 15000">
                        <p class="text-[10px] text-gray-400 mt-1">Data yang diajukan: <span id="modalProposedLuas">0</span> m²</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kolam Aktual</label>
                        <input type="number" name="jumlah_kolam_aktual" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: 2">
                        <p class="text-[10px] text-gray-400 mt-1">Data yang diajukan: <span id="modalProposedKolam">0</span> kolam</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Kolam</label>
                            <input type="text" name="kondisi_kolam" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: Baik">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ketepatan Data</label>
                            <input type="text" name="ketepatan_data" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: Tepat">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Verifikasi</label>
                        <textarea name="catatan_verifikasi" rows="3" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3 font-bold">Hasil Verifikasi</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="disetujui" class="hidden peer">
                                <div class="p-3 border rounded-xl text-center peer-checked:border-green-600 peer-checked:bg-green-50 transition">
                                    <i class="fa-regular fa-circle-check block mb-1"></i>
                                    <span class="text-[10px] font-bold">Disetujui</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="revisi" class="hidden peer">
                                <div class="p-3 border rounded-xl text-center peer-checked:border-orange-600 peer-checked:bg-orange-50 transition">
                                    <i class="fa-solid fa-circle-exclamation block mb-1 text-orange-600"></i>
                                    <span class="text-[10px] font-bold">Perlu Revisi</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="ditolak" class="hidden peer">
                                <div class="p-3 border rounded-xl text-center peer-checked:border-red-600 peer-checked:bg-red-50 transition">
                                    <i class="fa-regular fa-circle-xmark block mb-1 text-red-600"></i>
                                    <span class="text-[10px] font-bold">Ditolak</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50 flex gap-4">
                    <button type="button" onclick="closeVerificationModal()" class="flex-1 px-6 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-700 text-white rounded-xl text-sm font-bold hover:bg-green-800 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openVerificationModal(id, name, luas, kolam) {
        // Mengisi data ke dalam elemen modal
        document.getElementById('modalUserId').value = id;
        document.getElementById('modalUserName').innerText = name;
        document.getElementById('modalProposedLuas').innerText = luas;
        document.getElementById('modalProposedKolam').innerText = kolam;
        
        // Memunculkan modal
        const modal = document.getElementById('verificationModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Matikan scroll pada halaman utama saat modal muncul
    }

    function closeVerificationModal() {
        const modal = document.getElementById('verificationModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Aktifkan kembali scroll halaman
    }

    // Menutup modal jika area luar modal diklik
    window.onclick = function(event) {
        const modal = document.getElementById('verificationModal');
        if (event.target == modal) {
            closeVerificationModal();
        }
    }
</script>
@endsection