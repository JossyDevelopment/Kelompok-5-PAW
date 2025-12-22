@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Monitoring Permohonan Bantuan</h1>
        <p class="text-sm text-gray-400">Daftar Permohonan bantuan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total']) }}</h3>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Permohonan</p>
                <p class="text-[10px] text-green-500 font-bold mt-1">↑ 12% dari bulan lalu</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-check-double text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['disetujui'] }}</h3>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Disetujui</p>
                <p class="text-[10px] text-green-500 font-bold mt-1">76% completion rate</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-xmark text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['ditolak'] }}</h3>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Ditolak</p>
                <p class="text-[10px] text-gray-400 font-bold mt-1">5 Komoditas utama</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['menunggu'] }}</h3>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Menunggu Persetujuan</p>
                <p class="text-[10px] text-amber-500 font-bold mt-1 underline">Segera tindak lanjuti</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Persetujuan/Penolakan Terakhir</h3>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form action="{{ route('admin.permohonan.index') }}" method="GET" class="relative flex-1">
                    <input type="text" name="search" placeholder="Cari nama pemohon..." class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-2xl text-sm outline-none focus:ring-2 focus:ring-purple-500 bg-gray-50/50">
                </form>
                <button class="bg-purple-600 text-white px-6 py-3 rounded-2xl text-sm font-bold flex items-center gap-2 hover:bg-purple-700 transition shadow-lg shadow-purple-200">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-6">NO</th>
                        <th class="px-8 py-6">PEMOHON (LOKASI)</th>
                        <th class="px-8 py-6">JENIS BANTUAN</th>
                        <th class="px-8 py-6 text-center">TANGGAL AJUAN</th>
                        <th class="px-8 py-6 text-center">STATUS</th>
                        <th class="px-8 py-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($permohonan as $index => $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $permohonan->firstItem() + $index }}</td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-gray-800">{{ $item->nama_pemohon }}</p>
                            <p class="text-[11px] font-medium text-gray-400">({{ $item->lokasi }})</p>
                        </td>
                        <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $item->jenis_bantuan }}</td>
                        <td class="px-8 py-6 text-sm font-bold text-gray-500 text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="px-8 py-6 text-center">
                            @if($item->status == 'selesai')
                                <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100 uppercase">Disetujui</span>
                            @elseif($item->status == 'ditolak')
                                <span class="px-4 py-1.5 bg-red-50 text-red-600 text-[10px] font-black rounded-lg border border-red-100 uppercase">Ditolak</span>
                            @else
                                <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-[10px] font-black rounded-lg border border-amber-100 uppercase tracking-tighter text-nowrap">Menunggu Persetujuan</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="showDetail({{ $item->id }})" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition border border-blue-100 shadow-sm">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                                <button onclick="openVerifyModal({{ $item->id }})" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition border border-blue-100 shadow-sm">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="confirmDelete({{ $item->id }})" class="w-9 h-9 rounded-xl bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition border border-red-100 shadow-sm">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-gray-50/30 border-t border-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-400 font-medium">Menampilkan {{ $permohonan->firstItem() }} - {{ $permohonan->lastItem() }} dari {{ $permohonan->total() }} Data</p>
            {{ $permohonan->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<div id="modalDetail" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100">
            <div class="bg-purple-600 px-8 py-5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Detail Permohonan Bantuan</h3>
                <button onclick="closeDetail()" class="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
            </div>

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-2 gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">No. Permohonan</label>
                        <p id="detNo" class="text-sm font-black text-gray-800 uppercase"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Pemohon</label>
                        <p id="detNama" class="text-sm font-black text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tanggal Pengajuan</label>
                        <p id="detTgl" class="text-sm font-black text-gray-800"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Jenis Bantuan</label>
                        <p id="detJenis" class="text-sm font-black text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Skala Prioritas</label>
                        <p id="detPrioritas" class="text-sm font-black text-gray-800"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nilai Bantuan (Estimasi)</label>
                        <p id="detNilai" class="text-sm font-black text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Status Verifikasi Awal</label>
                        <p id="detStatus" class="text-sm font-black text-gray-800"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Catatan/Alasan Permohonan</label>
                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-50">
                        <p id="detCatatan" class="text-sm font-medium text-gray-600 leading-relaxed"></p>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button onclick="closeDetail()" class="px-8 py-3 bg-purple-600 text-white rounded-2xl text-sm font-bold hover:bg-purple-700 shadow-lg shadow-purple-200 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalVerify" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Input Hasil Verifikasi Bantuan</h3>
                <p id="verNama" class="text-sm text-gray-400 font-medium"></p>
            </div>

            <form id="formVerify" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="p-8 space-y-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">No. Permohonan: <span id="verNo" class="font-black text-gray-800 uppercase"></span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Skala Prioritas Hasil Verifikasi</label>
                        <select name="skala_prioritas" id="verPrioritas" required class="w-full border border-gray-200 rounded-2xl p-4 text-sm bg-gray-50/30 focus:ring-2 focus:ring-purple-500 outline-none">
                            <option value="Tinggi">Tinggi</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Tidak Prioritas">Tidak Prioritas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Verifikasi UPT</label>
                        <textarea name="catatan_petugas" id="verCatatan" rows="4" required class="w-full border border-gray-200 rounded-2xl p-4 text-sm bg-gray-50/30 focus:ring-2 focus:ring-purple-500 outline-none" placeholder="Masukkan ringkasan hasil verifikasi lapangan..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Rekomendasi Status</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="selesai" class="peer hidden" required>
                                <div class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition-all">
                                    <i class="fa-solid fa-circle-check text-xl text-gray-400 peer-checked:text-purple-600"></i>
                                    <span class="text-xs font-bold text-gray-500 peer-checked:text-purple-600">Disetujui</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="ditolak" class="peer hidden">
                                <div class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 peer-checked:border-red-600 peer-checked:bg-red-50 transition-all">
                                    <i class="fa-solid fa-circle-xmark text-xl text-gray-400 peer-checked:text-red-600"></i>
                                    <span class="text-xs font-bold text-gray-500 peer-checked:text-red-600">Ditolak</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50/50 flex gap-4 border-t border-gray-100">
                    <button type="button" onclick="closeVerifyModal()" class="flex-1 px-6 py-4 border border-gray-300 rounded-2xl text-sm font-bold text-gray-600 hover:bg-white transition">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-purple-600 text-white rounded-2xl text-sm font-bold hover:bg-purple-700 shadow-lg shadow-purple-200 transition">Simpan Hasil Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalHapus" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-gray-100 text-center">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-2xl font-black text-orange-500 tracking-widest uppercase">PERINGATAN!!!</h3>
            </div>

            <div class="p-8 space-y-6">
                <div class="flex justify-center">
                    <div class="w-24 h-24 text-orange-500 border-4 border-orange-500 rounded-2xl flex items-center justify-center rotate-45 overflow-hidden">
                        <i class="fa-solid fa-exclamation text-5xl -rotate-45"></i>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-700">Anda yakin ingin menghapus Data Ini?</p>
            </div>

            <div class="px-8 py-6 bg-gray-50/50 flex gap-4 border-t border-gray-100">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-6 py-4 border border-gray-300 rounded-2xl text-sm font-bold text-gray-600 hover:bg-white transition uppercase">Batal</button>
                <form id="formHapusData" action="" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-4 bg-orange-500 text-white rounded-2xl text-sm font-bold hover:bg-orange-600 transition shadow-lg shadow-orange-200 uppercase tracking-widest">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalSuccess" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-sm p-12 transform transition-all text-center">
            <div class="flex justify-center mb-8">
                <div class="w-24 h-24 bg-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-purple-200">
                    <i class="fa-solid fa-check text-5xl text-white"></i>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                {{ session('success_crud') }}
            </h3>
        </div>
    </div>
</div>

<script>
    function showDetail(id) {
    const modal = document.getElementById('modalDetail');
    
    // Pastikan URL mengarah ke /admin/permohonan/data/ID
    fetch(`/admin/permohonan/data/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Halaman tidak ditemukan (404)');
            return response.json();
        })
        .then(data => {
            // Isi data ke elemen modal
            document.getElementById('detNo').innerText = data.no_permohonan || ('BANT-2025-' + data.id);
            document.getElementById('detNama').innerText = data.nama_pemohon;
            document.getElementById('detTgl').innerText = new Date(data.created_at).toLocaleDateString('id-ID');
            document.getElementById('detJenis').innerText = data.jenis_bantuan;
            document.getElementById('detPrioritas').innerText = data.skala_prioritas || 'Sedang';
            
            // Format Rupiah
            const nilai = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.nilai_estimasi || 1000000);
            document.getElementById('detNilai').innerText = nilai;
            
            document.getElementById('detStatus').innerText = data.status === 'selesai' ? 'Sudah Verifikasi' : 'Proses Verifikasi';
            document.getElementById('detCatatan').innerText = data.detail_kebutuhan || 'Tidak ada catatan.';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error(error);
            alert('Gagal mengambil data. Pastikan Method getDetailData ada di AdminController.');
        });
}

    function closeDetail() {
        document.getElementById('modalDetail').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openVerifyModal(id) {
    const modal = document.getElementById('modalVerify');
    const form = document.getElementById('formVerify');

    fetch(`/admin/permohonan/data/${id}`)
        .then(response => response.json())
        .then(data => {
            // Isi data identitas
            document.getElementById('verNo').innerText = data.no_permohonan || ('BANT-2025-' + data.id);
            document.getElementById('verNama').innerText = data.nama_pemohon;
            
            // Isi form dengan data lama (jika sudah pernah verifikasi)
            document.getElementById('verPrioritas').value = data.skala_prioritas || '';
            document.getElementById('verCatatan').value = data.catatan_petugas || '';

            // Set URL form action secara dinamis
            let url = "{{ route('admin.permohonan.verifikasi.update', 0) }}";
            form.action = url.replace('/0', '/' + id);

            // Tampilkan modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
}

function closeVerifyModal() {
    document.getElementById('modalVerify').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmDelete(id) {
    const modal = document.getElementById('modalHapus');
    const form = document.getElementById('formHapusData');
    
    // Set URL action secara dinamis untuk permohonan
    let url = "{{ route('admin.permohonan.destroy', 0) }}";
    form.action = url.replace('/0', '/' + id);

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('modalHapus').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success_crud'))
            const modal = document.getElementById('modalSuccess');
            
            // Tampilkan modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Tutup otomatis setelah 2 detik
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 2000);
        @endif
    });
</script>
@endsection