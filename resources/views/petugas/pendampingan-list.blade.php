@extends('layouts.petugas')

@section('title', 'Daftar Permohonan')
@section('subtitle', 'Daftar Permohonan Pendampingan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Manajemen Permohonan & Penjadwalan</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b">
                    <th class="p-6">PEMBUDIDAYA</th>
                    <th class="p-6">TOPIK</th>
                    <th class="p-6">STATUS</th>
                    <th class="p-6">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendampingan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $item->nama_pembudidaya }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ $item->topik }}</td>
                    <td class="p-6">
                        @if($item->status == 'pending')
                            <span class="text-sm text-gray-500">Menunggu Jadwal</span>
                        @elseif($item->status == 'dijadwalkan')
                            <span class="text-sm text-green-600 font-medium">
                                Terjadwal ({{ \Carbon\Carbon::parse($item->jadwal_pendampingan)->format('Y-m-d') }})
                            </span>
                        @else
                            <span class="text-sm text-blue-600 font-medium">Selesai</span>
                        @endif
                    </td>
                    <td class="p-6 flex gap-2">
                        @if($item->status == 'pending')
                            <button onclick="openScheduleModal('{{ $item->id }}', '{{ $item->nama_pembudidaya }}', '{{ $item->topik }}')" 
                                    class="text-sm font-bold text-green-600 hover:text-green-800 transition flex items-center gap-1">
                                <i class="fa-solid fa-calendar-plus"></i> Jadwalkan
                            </button>
                        @else
                            <button onclick="openDetailModal('{{ $item->nama_pembudidaya }}', '{{ $item->topik }}', '{{ $item->created_at->format('Y-m-d') }}', '{{ $item->status }}', '{{ $item->jadwal_pendampingan }}')"
                            class="text-sm font-bold text-green-700 hover:text-green-900 transition flex items-center gap-1">
                            <i class="fa-solid fa-eye"></i> Lihat Detail
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-12 text-center text-gray-400">Belum ada permohonan pendampingan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="scheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50">
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden">
            <div class="bg-green-700 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="font-bold" id="scheduleTitle">Jadwalkan Kunjungan Pendampingan</h3>
                <button onclick="closeModal('scheduleModal')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('petugas.pendampingan.storeJadwal') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="id" id="scheduleId">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Nama Pembudidaya</label>
                        <p id="scheduleName" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Topik Permohonan</label>
                        <p id="scheduleTopic" class="text-sm font-bold text-gray-800"></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 border-t pt-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Tanggal Kunjungan:</label>
                        <input type="date" name="jadwal_pendampingan" required class="w-full border-b py-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Jam Kunjungan:</label>
                        <input type="time" name="jam_kunjungan" class="w-full border-b py-2 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700">Keterangan Petugas (Opsional):</label>
                    <textarea name="keterangan" rows="3" class="w-full border rounded-lg p-2 mt-2 text-sm" placeholder="Contoh: Petugas akan membawa alat uji kualitas air"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('scheduleModal')" class="px-6 py-2 border rounded-lg font-bold text-gray-600">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg font-bold">Simpan Jadwal Kunjungan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50">
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden">
            <div class="bg-green-700 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="font-bold" id="detailTitle">Detail Permohonan Pendampingan</h3>
                <button onclick="closeModal('detailModal')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Nama Pembudidaya</label>
                    <p id="detName" class="text-sm font-bold text-gray-800"></p>
                </div>
                <div class="grid grid-cols-2 gap-4 border-t pt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Topik Permohonan</label>
                        <p id="detTopic" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Tanggal Pengajuan</label>
                        <p id="detDate" class="text-sm font-bold text-gray-800"></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 border-t pt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Status Saat Ini</label>
                        <p id="detStatus" class="text-sm font-bold text-green-600"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Ketersediaan Pembudidaya</label>
                        <p class="text-sm font-bold text-gray-800">Tersedia</p>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg text-sm text-gray-600">
                    Kolam beton. Terdapat masalah pH air dan amonia tinggi. Ingin konsultasi cara penanganannya. Lokasi: Pesisir.
                </div>
                <div class="flex justify-end">
                    <button onclick="closeModal('detailModal')" class="px-8 py-2 bg-green-700 text-white rounded-lg font-bold">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openScheduleModal(id, name, topic) {
        document.getElementById('scheduleId').value = id;
        document.getElementById('scheduleName').innerText = name;
        document.getElementById('scheduleTopic').innerText = topic;
        document.getElementById('scheduleTitle').innerText = "Jadwalkan Kunjungan Pendampingan: " + name;
        document.getElementById('scheduleModal').classList.remove('hidden');
    }

    function openDetailModal(name, topic, date, status, schedule) {
        document.getElementById('detName').innerText = name;
        document.getElementById('detTopic').innerText = topic;
        document.getElementById('detDate').innerText = date;
        document.getElementById('detailTitle').innerText = "Detail Permohonan Pendampingan: " + name;
        
        let statusText = status === 'pending' ? 'Menunggu Jadwal' : 'Terjadwal (' + schedule + ')';
        document.getElementById('detStatus').innerText = statusText;
        
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection