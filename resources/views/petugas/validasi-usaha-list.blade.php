@extends('layouts.petugas')

@section('title', 'Verifikasi Pembudidaya')
@section('subtitle', 'Verifikasi Data dan Usaha Budidaya')

@section('content')
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800">Daftar Pembudidaya Menunggu Validasi Detail Usaha</h3>
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
                <input type="text" placeholder="Cari" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 bg-gray-50/50">
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
                    <th class="p-6">NAMA PEMBUDIDAYA</th>
                    <th class="p-6">KOMODITAS UTAMA</th>
                    <th class="p-6">LUAS LAHAN (M²)</th>
                    <th class="p-6">STATUS IZIN USAHA</th>
                    <th class="p-6">AKSI VALIDASI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pembudidaya as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $user->nama_lengkap }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ $user->komoditas ?? 'Belum diisi' }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ number_format($user->luas_lahan ?? 0) }}</td>
                    <td class="p-6">
                        @if($user->status_izin == 'disetujui')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg border border-green-200">Disetujui</span>
                        @elseif($user->status_izin == 'revisi')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-bold rounded-lg border border-orange-200">Revisi</span>
                        @elseif($user->status_izin == 'ditolak')
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg border border-red-200">Ditolak</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-[10px] font-bold rounded-lg border border-gray-200">Proses</span>
                        @endif
                    </td>
                    <td class="p-6">
                        <button 
                            type="button"
                            onclick="openValidationModal('{{ $user->id_user }}', '{{ $user->nama_lengkap }}', '{{ $user->komoditas }}', '{{ $user->luas_lahan }}', '{{ $user->alamat }}, Desa {{ $user->desa }}, Kec. {{ $user->kecamatan }}')"
                            class="text-sm font-bold text-green-700 hover:text-green-900 transition">
                            Validasi Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">Tidak ada data untuk divalidasi.</td>
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

<div id="validationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="px-8 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Detail Verifikasi Usaha</h3>
                <p id="modalHeaderSub" class="text-xs text-gray-400"></p>
            </div>

            <form action="{{ route('petugas.verifikasi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_user" id="modalUserId">

                <div class="px-8 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">1. Data Dasar Pembudidaya</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Nama Pembudidaya</label>
                                <p id="modalNama" class="text-sm font-bold text-gray-800"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Komoditas Utama</label>
                                <p id="modalKomoditas" class="text-sm font-bold text-gray-800"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Luas Lahan (M²)</label>
                                <p id="modalLuas" class="text-sm font-bold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">2. Detail Lokasi Usaha</h4>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Alamat Lengkap</label>
                        <p id="modalAlamat" class="text-sm text-gray-700 font-medium"></p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">3. Keputusan Validasi Lapangan</h4>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="disetujui" class="hidden peer" required>
                                <div class="p-4 border-2 rounded-xl text-center peer-checked:border-green-600 peer-checked:bg-green-50 transition">
                                    <i class="fa-regular fa-circle-check block text-xl mb-1 text-gray-400 group-hover:text-green-600 peer-checked:text-green-600"></i>
                                    <span class="text-[11px] font-bold text-gray-600">Disetujui</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="revisi" class="hidden peer">
                                <div class="p-4 border-2 rounded-xl text-center peer-checked:border-orange-600 peer-checked:bg-orange-50 transition">
                                    <i class="fa-solid fa-circle-exclamation block text-xl mb-1 text-gray-400 group-hover:text-orange-600 peer-checked:text-orange-600"></i>
                                    <span class="text-[11px] font-bold text-gray-600">Perlu Revisi</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_verifikasi" value="ditolak" class="hidden peer">
                                <div class="p-4 border-2 rounded-xl text-center peer-checked:border-red-600 peer-checked:bg-red-50 transition">
                                    <i class="fa-regular fa-circle-xmark block text-xl mb-1 text-gray-400 group-hover:text-red-600 peer-checked:text-red-600"></i>
                                    <span class="text-[11px] font-bold text-gray-600">Ditolak</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Catatan/Keterangan Petugas (Wajib):</label>
                        <textarea name="catatan_verifikasi" required rows="3" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500 outline-none transition" placeholder="Contoh: Lokasi dan luas lahan yang sesuai..."></textarea>
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50 flex gap-4">
                    <button type="button" onclick="closeValidationModal()" class="flex-1 px-6 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-700 text-white rounded-xl text-sm font-bold hover:bg-green-800 transition">Simpan & Proses Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openValidationModal(id, nama, komoditas, luas, alamat) {
        document.getElementById('modalUserId').value = id;
        document.getElementById('modalHeaderSub').innerText = nama;
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalKomoditas').innerText = komoditas || 'Belum diisi';
        document.getElementById('modalLuas').innerText = luas + ' M²';
        document.getElementById('modalAlamat').innerText = alamat;

        const modal = document.getElementById('validationModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeValidationModal() {
        const modal = document.getElementById('validationModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Tutup jika klik area luar modal
    window.onclick = function(event) {
        const modal = document.getElementById('validationModal');
        if (event.target == modal) {
            closeValidationModal();
        }
    }
</script>
@endsection