@extends('layouts.pembudidaya')

@section('title', 'Status & Lacak Permohonan Bantuan')
@section('subtitle', 'Lacak status permohonan bantuan Anda secara waktu nyata dari pengajuan hingga pengiriman')

@section('content') 
@php
    // Gunakan ?? untuk memberikan nilai default jika variabel null
    $currentStatusIzin = $status_izin ?? 'pending';
    $isDone = ($currentStatusIzin == 'disetujui');
    
    // Gunakan ?-> (Null Safe) agar tidak crash jika $profil kosong
    $isScheduled = (($profil?->status_survei ?? 'belum') == 'sudah' && !$isDone);
@endphp

<div class="mb-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                {{-- Warna Icon Berdasarkan Progres (Null Safe) --}}
                <div class="w-12 h-12 flex items-center justify-center text-xl rounded-2xl 
                    {{ $isDone ? 'bg-green-50 text-green-600' : ($isScheduled ? 'bg-blue-50 text-blue-600' : 'bg-gray-50 text-gray-400') }}">
                    <i class="fa-solid {{ $isDone ? 'fa-user-check' : 'fa-clipboard-check' }}"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Status Verifikasi Akun & Lapangan</h3>
                    <p class="text-xs text-gray-400">Tahap pengecekan kelayakan usaha oleh petugas UPT</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($isDone)
                    <span class="px-4 py-2 bg-green-100 text-green-700 text-[10px] font-black rounded-xl border border-green-200 uppercase">
                        <i class="fa-solid fa-check-double mr-1"></i> Akun Terverifikasi
                    </span>
                @elseif($isScheduled)
                    <div class="text-right mr-4">
                        <p class="text-[10px] font-bold text-blue-600 uppercase">Jadwal Kunjungan:</p>
                        {{-- Parsing Tanggal dengan proteksi jika field tanggal kosong --}}
                        <p class="text-sm font-black text-gray-800">
                            {{ $profil?->tanggal_survei ? \Carbon\Carbon::parse($profil->tanggal_survei)->format('d F Y') : 'Belum ditentukan' }}
                        </p>
                    </div>
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 text-[10px] font-black rounded-xl border border-blue-200 uppercase animate-pulse">
                        Survei Dijadwalkan
                    </span>
                @else
                    <span class="px-4 py-2 bg-gray-100 text-gray-400 text-[10px] font-black rounded-xl border border-gray-200 uppercase">
                        Menunggu Penjadwalan
                    </span>
                @endif
            </div>
        </div>
        
        @if($isDone)
            <div class="mt-4 p-4 bg-green-50/50 border border-green-100 rounded-xl">
                <p class="text-xs text-green-700 leading-relaxed italic">
                    <i class="fa-solid fa-circle-check mr-1"></i> 
                    Selamat! Akun Anda telah terverifikasi. Anda dapat mengajukan bantuan atau pendampingan.
                </p>
            </div>
        @elseif($isScheduled && $profil?->tanggal_survei)
            <div class="mt-4 p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                <p class="text-xs text-blue-700 leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1"></i> 
                    Petugas UPT dijadwalkan datang pada <b>{{ \Carbon\Carbon::parse($profil->tanggal_survei)->format('d F Y') }}</b>.
                </p>
            </div>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                    <th class="p-6">No. Permohonan</th>
                    <th class="p-6">Jenis Bantuan</th>
                    <th class="p-6">Tgl Pengajuan</th>
                    <th class="p-6">Status Terakhir</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($permohonan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm font-medium text-gray-900">{{ $item->no_tiket }}</td>
                    <td class="p-6 text-sm text-gray-600">
                        {{ ucfirst($item->jenis_bantuan) }} 
                        @if($item->jenis_bantuan == 'benih') Ikan @endif
                    </td>
                    <td class="p-6 text-sm text-gray-600">
                        {{ $item->created_at->format('d M Y') }}
                    </td>

                    <td class="p-6">
                        @php
                            $badgeColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            $badgeText = 'Menunggu Verifikasi';

                            if($item->status == 'verifikasi_upt') {
                                $badgeColor = 'bg-orange-100 text-orange-700 border-orange-200';
                                $badgeText = 'Verifikasi UPT';
                            } elseif($item->status == 'revisi') {
                                $badgeColor = 'bg-amber-100 text-amber-700 border-amber-200';
                                $badgeText = 'Perlu Revisi';
                            } elseif($item->status == 'ditolak') {
                                $badgeColor = 'bg-red-100 text-red-700 border-red-200';
                                $badgeText = 'Ditolak';
                            } elseif($item->status == 'disetujui_admin') {
                                $badgeColor = 'bg-blue-50 text-blue-600 border-blue-200';
                                $badgeText = 'Disetujui Admin';
                            } elseif($item->status == 'dikirim') {
                                $badgeColor = 'bg-blue-100 text-blue-700 border-blue-200';
                                $badgeText = 'Dalam Pengiriman';
                            } elseif($item->status == 'selesai') {
                                $badgeColor = 'bg-green-100 text-green-700 border-green-200';
                                $badgeText = 'Selesai';
                            }
                        @endphp

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                            {{ $badgeText }}
                        </span>

                        {{-- Info monitoring di bawah status (jika ada) --}}
                        @if($item->tanggal_monitoring_terakhir)
                            <div class="mt-1 flex items-center gap-1 text-[9px] font-bold text-amber-600 uppercase">
                                <i class="fa-solid fa-clock"></i> Kunjungan: {{ \Carbon\Carbon::parse($item->tanggal_monitoring_terakhir)->format('d/m/Y') }}
                            </div>
                        @endif
                    </td>

                    <td class="p-6 text-right">
                        @if($item->status == 'dikirim')
                            <button onclick="showTracking(
                                '{{ $item->no_tiket }}', 
                                '{{ ucfirst($item->jenis_bantuan) }}', 
                                '{{ $badgeText }}'
                            )" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-2 justify-end ml-auto">
                                <i class="fa-solid fa-truck-fast"></i> Lacak
                            </button>
                        @else
                            <button onclick="showDetail(
                                '{{ $item->no_tiket }}', 
                                '{{ ucfirst($item->jenis_bantuan) }}', 
                                '{{ $badgeText }}',
                                '{{ $item->catatan_petugas ?? 'Permohonan sedang dalam tahap peninjauan.' }}',
                                '{{ $item->tanggal_monitoring_terakhir ? \Carbon\Carbon::parse($item->tanggal_monitoring_terakhir)->format('d F Y') : '' }}'
                            )" class="text-sm font-medium text-gray-400 hover:text-blue-600 hover:underline">
                                Lihat Detail
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400 font-medium">Belum ada riwayat permohonan bantuan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL POPUP DINAMIS --}}
<div id="modal-popup" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300" id="modal-content">
        
        <div id="modal-header" class="px-6 py-4 flex justify-between items-center text-white">
            <h3 class="font-bold text-lg"><span id="modal-label-type">Detail</span> (<span id="modal-title-ticket">...</span>)</h3>
            <button onclick="closeModal()" class="opacity-70 hover:opacity-100 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No. Tiket</p>
                    <p class="text-sm font-bold text-gray-900" id="modal-no-tiket">-</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Bantuan</p>
                    <p class="text-sm font-bold text-gray-900" id="modal-jenis">-</p>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Saat Ini</p>
                <p class="text-xl font-black text-gray-800" id="modal-status-display">-</p>
            </div>

            {{-- Catatan Petugas --}}
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2" id="modal-note-label">Catatan Petugas</p>
                <p class="text-sm text-gray-600 leading-relaxed italic" id="modal-catatan">...</p>
            </div>

            {{-- JADWAL MONITORING (Kini berada di dalam modal content agar muncul) --}}
            <div id="section-monitoring" class="hidden p-4 bg-amber-50 border border-amber-200 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white shadow-sm">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Jadwal Kunjungan Monitoring</p>
                        <p class="text-sm font-black text-gray-800" id="modal-tgl-monitoring">-</p>
                        <p class="text-[10px] text-gray-500 mt-1 italic">*Mohon siapkan lokasi usaha untuk ditinjau oleh petugas UPT.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-end">
            <button onclick="closeModal()" class="bg-gray-800 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-black transition shadow-sm">Tutup</button>
        </div>
    </div>
</div>

<script>
    function showTracking(noTiket, jenis, statusText) {
        updateModalLayout('Lacak Pengiriman', 'bg-blue-600', 'INFORMASI PENGIRIMAN');
        document.getElementById('modal-catatan').innerText = "Bantuan sedang dalam perjalanan. Petugas akan menghubungi Anda saat tiba di lokasi.";
        document.getElementById('section-monitoring').classList.add('hidden'); // Sembunyikan monitoring di mode lacak
        fillCommonData(noTiket, jenis, statusText);
        bukaModal();
    }

    function showDetail(noTiket, jenis, statusText, catatan, tglMonitoring) {
        updateModalLayout('Detail Permohonan', 'bg-blue-600', 'CATATAN PETUGAS');
        document.getElementById('modal-catatan').innerText = catatan;
        fillCommonData(noTiket, jenis, statusText);
        
        // Logika Menampilkan Section Monitoring
        const sectionMonev = document.getElementById('section-monitoring');
        if(tglMonitoring && tglMonitoring !== '') {
            sectionMonev.classList.remove('hidden');
            document.getElementById('modal-tgl-monitoring').innerText = tglMonitoring;
        } else {
            sectionMonev.classList.add('hidden');
        }
        
        bukaModal();
    }

    function updateModalLayout(label, headerClass, noteLabel) {
        document.getElementById('modal-label-type').innerText = label;
        document.getElementById('modal-header').className = `px-6 py-4 flex justify-between items-center text-white ${headerClass}`;
        document.getElementById('modal-note-label').innerText = noteLabel;
    }

    function fillCommonData(noTiket, jenis, statusText) {
        document.getElementById('modal-title-ticket').innerText = noTiket;
        document.getElementById('modal-no-tiket').innerText = noTiket;
        document.getElementById('modal-jenis').innerText = jenis;
        document.getElementById('modal-status-display').innerText = statusText;
    }

    function bukaModal() {
        const modal = document.getElementById('modal-popup');
        const content = document.getElementById('modal-content');
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.replace('scale-95', 'scale-100'), 10);
    }

    function closeModal() {
        const modal = document.getElementById('modal-popup');
        const content = document.getElementById('modal-content');
        content.classList.replace('scale-100', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
</script>

@endsection