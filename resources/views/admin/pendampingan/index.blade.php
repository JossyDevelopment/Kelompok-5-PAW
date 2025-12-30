@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Pendampingan</h1>
        <p class="text-sm text-gray-400 font-medium tracking-tight">Monitoring Pendampingan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Permohonan</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Selesai</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['selesai'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Sedang Berjalan</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['berjalan'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Menunggu Jadwal</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['menunggu'] }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm flex gap-4">
        <a href="{{ route('admin.pendampingan.index', ['tab' => 'monitoring']) }}" 
           class="px-8 py-3 rounded-2xl text-sm font-bold transition {{ $tab == 'monitoring' ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
            Monitoring Pelaksana
        </a>
        <a href="{{ route('admin.pendampingan.index', ['tab' => 'rekap']) }}" 
           class="px-8 py-3 rounded-2xl text-sm font-bold transition {{ $tab == 'rekap' ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
            Rekap Permohonan
        </a>
    </div>

    @if($tab == 'rekap')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
                <h3 class="text-lg font-bold text-gray-800">Permintaan Berdasarkan Topik</h3>
                <div class="space-y-6">
                    @foreach($topikStats as $t)
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold text-gray-700">
                            <span>{{ $t->topik }}</span>
                            <span class="text-gray-400">{{ $t->total }} ({{ $stats['total'] > 0 ? round(($t->total / $stats['total']) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($t->total / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
                <h3 class="text-lg font-bold text-gray-800">Permintaan Berdasarkan Wilayah</h3>
                <div class="space-y-6">
                    @foreach($wilayahStats as $w)
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold text-gray-700">
                            <span>{{ $w->wilayah ?? 'Tidak Diketahui' }}</span>
                            <span class="text-gray-400">{{ $w->total }} ({{ $stats['total'] > 0 ? round(($w->total / $stats['total']) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($w->total / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden mt-6">
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="px-8 py-6">NO</th>
                            <th class="px-8 py-6">PETUGAS UPT</th>
                            <th class="px-8 py-6">PEMBUDIDAYA</th>
                            <th class="px-8 py-6">TOPIK PENDAMPINGAN</th>
                            <th class="px-8 py-6">JADWAL/SELESAI</th>
                            <th class="px-8 py-6 text-center">STATUS</th>
                            <th class="px-8 py-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pendampingan as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $pendampingan->firstItem() + $index }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-800">Budi Santoso</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-800">{{ $item->nama_pembudidaya }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $item->topik }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-500">{{ $item->jadwal_pendampingan ? date('d/m/Y', strtotime($item->jadwal_pendampingan)) : '-' }}</td>
                            <td class="px-8 py-6 text-center">
                                @if($item->status == 'dijadwalkan')
                                    <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-[10px] font-black rounded-lg border border-amber-100 uppercase">Dijadwalkan</span>
                                @elseif($item->status == 'selesai')
                                    <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100 uppercase">Selesai</span>
                                @elseif($item->status == 'sedang_berjalan')
                                    <span class="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100 uppercase">Sedang Berjalan</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <button onclick="openDetailPendampingan({{ $item->id }})" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition border border-blue-100 mx-auto">
                                    <i class="fa-solid fa-file-lines text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<div id="modalDetailPendampingan" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100">
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Detail Pendampingan</h3>
                <button onclick="closeDetailPendampingan()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <div class="p-8 space-y-6">
                <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50/30">
                    <h4 class="text-sm font-bold text-gray-800 mb-4">Informasi Pendampingan</h4>
                    <div class="grid grid-cols-1 gap-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Topik:</span>
                            <span id="p-topik" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Status:</span>
                            <span id="p-status-badge" class="px-3 py-1 rounded-lg text-[10px] font-black uppercase"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Jadwal:</span>
                            <span id="p-jadwal" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="mt-2">
                            <label id="p-label-keterangan" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block"></label>
                            
                            <div class="mt-1 p-4 bg-gray-50 border border-gray-100 rounded-xl text-gray-700">
                                <p id="p-konten-keterangan" class="text-sm leading-relaxed"></p>
                            </div>
                        </div>

                        <div id="container-rekomendasi" class="mt-4 hidden">
                            <label class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-1 block">Rekomendasi Tindak Lanjut:</label>
                            <div class="p-4 bg-purple-50 border border-purple-100 rounded-xl text-purple-700 text-sm italic">
                                <p id="p-rekomendasi"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-100 rounded-2xl p-6">
                    <h4 class="text-sm font-bold text-gray-800 mb-4">Data Pembudidaya</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-400">Nama:</span>
                            <span id="p-nama" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-400">Telepon:</span>
                            <span id="p-telp" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-400">Jenis Usaha:</span>
                            <span id="p-usaha" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-400">Luas Area:</span>
                            <span id="p-luas" class="font-bold text-gray-800"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-400">Alamat:</span>
                            <span id="p-alamat" class="font-medium text-gray-600 mt-1"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 flex gap-4 border-t border-gray-100">
                <button onclick="closeDetailPendampingan()" class="flex-1 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-white transition">Tutup</button>
                <button id="btn-unduh" class="flex-1 py-3 bg-purple-600 text-white rounded-xl text-sm font-bold hover:bg-purple-700 shadow-lg shadow-purple-200 transition">Unduh Laporan</button>
            </div>
        </div>
    </div>
</div>

<script>
function openDetailPendampingan(id) {
    const modal = document.getElementById('modalDetailPendampingan');
    
    fetch(`/admin/pendampingan/data/${id}`)
        .then(response => response.json())
        .then(data => {
            // A. REFERENSI ELEMEN DINAMIS
            const labelElemen = document.getElementById('p-label-keterangan');
            const kontenElemen = document.getElementById('p-konten-keterangan');
            const rekomContainer = document.getElementById('container-rekomendasi');
            const jadwalContainer = document.getElementById('p-jadwal');

            // 1. LOGIKA DINAMIS KONTEN (PEMBUDIDAYA VS PETUGAS)
            if (data.status === 'selesai') {
                // Tampilan untuk Status SELESAI
                labelElemen.innerText = 'Hasil Teknis Pendampingan (Laporan Petugas):';
                kontenElemen.innerText = data.hasil_pendampingan || 'Petugas belum mengisi detail hasil.';
                
                // Tampilkan & Isi Rekomendasi
                rekomContainer.classList.remove('hidden');
                document.getElementById('p-rekomendasi').innerText = data.rekomendasi_tindak_lanjut || '-';

                // Tampilan Jadwal (Mulai & Selesai)
                if (data.waktu_realisasi_selesai) {
                    let tglMulai = new Date(data.jadwal_pendampingan).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    let jamMulai = data.jam_kunjungan ? data.jam_kunjungan.substring(0, 5) : '00:00';
                    let tglSelesai = new Date(data.waktu_realisasi_selesai).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    let jamSelesai = new Date(data.waktu_realisasi_selesai).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                    jadwalContainer.innerHTML = `
                        <div class="text-[10px] text-blue-600 font-black uppercase mb-1">Jadwal: ${tglMulai} - ${jamMulai} WIB</div>
                        <div class="text-[10px] text-green-600 font-black uppercase">Selesai: ${tglSelesai} - ${jamSelesai} WIB</div>
                    `;
                }
            } else {
                // Tampilan untuk Status DIJADWALKAN / PENDING
                labelElemen.innerText = 'Keterangan Tambahan (Permintaan Pembudidaya):';
                kontenElemen.innerText = 'Permintaan pendampingan untuk ' + (data.detail_keluhan || '-');
                
                // Sembunyikan Rekomendasi
                rekomContainer.classList.add('hidden');

                // Tampilan Jadwal Standar
                let teks = data.jadwal_pendampingan 
                    ? new Date(data.jadwal_pendampingan).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) 
                    : 'Belum Dijadwalkan';

                if (data.status === 'dijadwalkan' && data.jam_kunjungan) {
                    teks += ` (Pukul ${data.jam_kunjungan.substring(0, 5)} WIB)`;
                }
                jadwalContainer.innerText = teks;
            }

            // 2. LOGIKA BADGE STATUS & TOMBOL UNDUH (Sesuai Kode Anda)
            const badge = document.getElementById('p-status-badge');
            badge.innerText = data.status;
            if(data.status === 'selesai') {
                badge.className = 'px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-green-50 text-green-600 border border-green-100';
                document.getElementById('btn-unduh').classList.remove('hidden');
            } else if(data.status === 'dijadwalkan') {
                badge.className = 'px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-50 text-amber-600 border border-amber-100';
                document.getElementById('btn-unduh').classList.add('hidden');
            } else {
                badge.className = 'px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-blue-50 text-blue-600 border border-blue-100';
                document.getElementById('btn-unduh').classList.add('hidden');
            }

            // 3. ISI DATA PEMBUDIDAYA
            document.getElementById('p-topik').innerText = data.topik;
            document.getElementById('p-nama').innerText = data.nama_pembudidaya;
            document.getElementById('p-telp').innerText = data.nomor_hp || '-';
            document.getElementById('p-usaha').innerText = 'Budidaya Ikan ' + (data.jenis_ikan || '-');
            document.getElementById('p-luas').innerText = (data.luas_kolam || '0') + ' m² (' + (data.jumlah_kolam || '0') + ' Kolam)';
            document.getElementById('p-alamat').innerText = data.alamat || '-';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
}

function closeDetailPendampingan() {
    document.getElementById('modalDetailPendampingan').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
@endsection