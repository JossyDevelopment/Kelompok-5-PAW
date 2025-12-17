@extends('layouts.pembudidaya')

@section('title', 'Status & Lacak Permohonan Bantuan')
@section('subtitle', 'Lacak status permohonan bantuan Anda secara waktu nyata dari pengajuan hingga pengiriman')

@section('content')

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
                            // Default Style (Kuning / Pending)
                            $badgeColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            $badgeText = 'Menunggu Verifikasi';

                            if($item->status == 'verifikasi_upt') {
                                $badgeColor = 'bg-orange-100 text-orange-700 border-orange-200';
                                $badgeText = 'Verifikasi UPT';
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
                    </td>

                    <td class="p-6 text-right">
                        @if($item->status == 'dikirim')
                            <button onclick="showTracking(
                                '{{ $item->no_tiket }}', 
                                '{{ ucfirst($item->jenis_bantuan) }}', 
                                '{{ $item->created_at->format('d M Y') }}', 
                                '{{ $badgeText }}'
                            )" class="text-sm font-bold text-green-600 hover:text-green-800 hover:underline">
                                Lacak
                            </button>
                        @else
                            <button onclick="showDetail(
                                '{{ $item->no_tiket }}', 
                                '{{ ucfirst($item->jenis_bantuan) }}', 
                                '{{ $item->created_at->format('d M Y') }}', 
                                '{{ $badgeText }}'
                            )" class="text-sm font-medium text-gray-400 hover:text-blue-600 hover:underline">
                                Lihat Detail
                            </button>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <i class="fa-regular fa-folder-open text-3xl mb-2"></i>
                            <span>Belum ada riwayat permohonan bantuan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100 flex justify-end">
        <div class="flex gap-1 text-sm text-gray-500">
            <span class="px-3 py-1 border rounded bg-gray-50 text-gray-300 cursor-not-allowed">Prev</span>
            <span class="px-3 py-1 border rounded bg-blue-600 text-white">1</span>
            <span class="px-3 py-1 border rounded hover:bg-gray-50 cursor-pointer">Next</span>
        </div>
    </div>

</div>

<div id="modal-popup" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="modal-content">
        
        <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold text-lg"><span id="modal-label-type">Detail</span> (<span id="modal-title-ticket">...</span>)</h3>
            <button onclick="closeModal()" class="text-blue-200 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="p-6 space-y-5">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">NO. PEMOHON</p>
                <p class="text-base font-bold text-gray-900" id="modal-no-tiket">-</p>
            </div>
            <div class="border-t border-gray-100"></div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">JENIS BANTUAN</p>
                <p class="text-base font-bold text-gray-900" id="modal-jenis">-</p>
            </div>
            <div class="border-t border-gray-100"></div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">KETERANGAN</p>
                <p class="text-lg font-bold text-blue-600" id="modal-jumlah">Permohonan sedang diproses</p>
            </div>
            <div class="border-t border-gray-100"></div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">STATUS TERKINI</p>
                <p class="text-sm text-gray-600" id="modal-catatan">...</p>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-end">
            <button onclick="closeModal()" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-blue-800 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function showTracking(noTiket, jenis, tanggal, statusText) {
        document.getElementById('modal-label-type').innerText = "Lacak Bantuan"; 
        isiDataModal(noTiket, jenis, tanggal, statusText);
        document.getElementById('modal-catatan').innerText = "Status: " + statusText + ". Estimasi tiba: 2 hari kerja.";
        bukaModal();
    }

    function showDetail(noTiket, jenis, tanggal, statusText) {
        document.getElementById('modal-label-type').innerText = "Detail Permohonan";
        isiDataModal(noTiket, jenis, tanggal, statusText);
        document.getElementById('modal-catatan').innerText = "Status saat ini: " + statusText + ". Diajukan pada: " + tanggal;
        bukaModal();
    }

    function isiDataModal(noTiket, jenis, tanggal, statusText) {
        document.getElementById('modal-title-ticket').innerText = noTiket;
        document.getElementById('modal-no-tiket').innerText = noTiket;
        document.getElementById('modal-jenis').innerText = jenis;
    }

    function bukaModal() {
        const modal = document.getElementById('modal-popup');
        const content = document.getElementById('modal-content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('modal-popup');
        const content = document.getElementById('modal-content');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
    
    document.getElementById('modal-popup').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>

@endsection
