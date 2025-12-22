@extends('layouts.petugas')

@section('title', 'Verifikasi Kelayakan')
@section('subtitle', 'Daftar permohonan bantuan menunggu validasi lapangan')

@section('content')
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800">Daftar Permohonan Kelayakan</h3>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('petugas.bantuan.index') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Ringkasan Tugas
            </a>
        </div>
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative w-full md:w-96">
                <input type="text" placeholder="Cari Permohonan" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50/50 outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-green-800 transition">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-6">PEMBUDIDAYA</th>
                    <th class="p-6">JENIS BANTUAN</th>
                    <th class="p-6">JADWAL SURVEI</th>
                    <th class="p-6">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($permohonan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6">
                        <p class="text-sm font-bold text-gray-800">{{ $item->nama_pembudidaya }}</p>
                        <p class="text-[10px] text-gray-400">Desa {{ $item->desa }}</p>
                    </td>
                    <td class="p-6 text-sm text-gray-500">{{ ucfirst($item->jenis_bantuan) }}</td>
                    <td class="p-6 text-sm text-gray-500 italic">
                        {{ $item->status_survei == 'sudah' ? 'Terjadwal' : 'Belum Diverifikasi' }}
                    </td>
                    <td class="p-6">
                    <a href="{{ route('petugas.bantuan.detail', $item->id) }}" 
                    class="text-sm font-bold text-green-700 hover:text-green-900 transition">
                    Verifikasi Detail
                    </a>
                </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-12 text-center text-gray-400">Tidak ada data untuk diproses.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="eligibilityModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all border border-gray-100">
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Detail Verifikasi Usaha</h3>
                    <p id="modalHeaderName" class="text-sm text-gray-400"></p>
                </div>
                <button onclick="closeEligibilityModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('petugas.bantuan.kelayakan') }}" method="POST">
                @csrf
                <input type="hidden" name="id_permohonan" id="modalAidId">

                <div class="p-8 space-y-8 max-h-[70vh] overflow-y-auto">
                    <section>
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">1. Data Dasar Pembudidaya</h4>
                        <div class="grid grid-cols-3 gap-6 bg-gray-50 p-4 rounded-xl">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Nama Pembudidaya</label>
                                <p id="modalName" class="text-sm font-bold text-gray-800"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Komoditas Utama</label>
                                <p id="modalCommodity" class="text-sm font-bold text-gray-800"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Luas Lahan (M²)</label>
                                <p id="modalArea" class="text-sm font-bold text-gray-800"></p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">2. Detail Lokasi Usaha</h4>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase">Alamat Lengkap</label>
                            <p id="modalAddress" class="text-sm text-gray-800 font-bold leading-relaxed"></p>
                        </div>
                    </section>

                    <section>
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">3. Keputusan Validasi Lapangan</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_kelayakan" value="disetujui" class="hidden peer" required>
                                <div class="p-4 border-2 border-gray-100 rounded-xl text-center peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                    <i class="fa-regular fa-circle-check block text-2xl mb-2 text-gray-300 peer-checked:text-green-600"></i>
                                    <span class="text-xs font-bold text-gray-600">Disetujui</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_kelayakan" value="revisi" class="hidden peer">
                                <div class="p-4 border-2 border-gray-100 rounded-xl text-center peer-checked:border-orange-600 peer-checked:bg-orange-50 transition-all">
                                    <i class="fa-solid fa-circle-exclamation block text-2xl mb-2 text-gray-300 peer-checked:text-orange-600"></i>
                                    <span class="text-xs font-bold text-gray-600">Perlu Revisi</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="hasil_kelayakan" value="ditolak" class="hidden peer">
                                <div class="p-4 border-2 border-gray-100 rounded-xl text-center peer-checked:border-red-600 peer-checked:bg-red-50 transition-all">
                                    <i class="fa-regular fa-circle-xmark block text-2xl mb-2 text-gray-300 peer-checked:text-red-600"></i>
                                    <span class="text-xs font-bold text-gray-600">Ditolak</span>
                                </div>
                            </label>
                        </div>
                    </section>

                    <section>
                        <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Catatan/Keterangan Petugas (Wajib):</label>
                        <textarea name="catatan_kelayakan" required rows="4" 
                            class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-green-500 outline-none transition" 
                            placeholder="Tuliskan alasan kelayakan..."></textarea>
                    </section>
                </div>

                <div class="px-8 py-6 bg-gray-50 flex gap-4 border-t border-gray-100">
                    <button type="button" onclick="closeEligibilityModal()" class="flex-1 px-6 py-4 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-white transition uppercase tracking-widest">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-green-700 text-white rounded-xl text-sm font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20 uppercase tracking-widest">Simpan & Proses Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEligibilityModal(id, name, type, area, address, commodity, date) {
        // Set data
        document.getElementById('modalAidId').value = id;
        document.getElementById('modalHeaderName').innerText = name;
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalCommodity').innerText = commodity || 'Belum diisi';
        document.getElementById('modalArea').innerText = area + ' M²';
        document.getElementById('modalAddress').innerText = address;
        document.getElementById('modalDate').innerText = date;

        const modal = document.getElementById('eligibilityModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEligibilityModal() {
        const modal = document.getElementById('eligibilityModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection