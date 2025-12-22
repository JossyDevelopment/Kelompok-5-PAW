@extends('layouts.petugas')

@section('title', 'Verifikasi Permohonan Bantuan')
@section('subtitle', 'Verifikasi kelayakan permohonan bantuan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Kelayakan Permohonan</h3>
        <p class="text-sm text-gray-500 mb-4">Memeriksa kriteria kelayakan (skala usaha, status terdaftar, kepemilikan lahan, dll.)</p>
        <p class="text-green-700 font-medium mb-6">Menunggu: {{ $menunggu_kelayakan }} Permohonan</p>
        <a href="{{ route('petugas.bantuan.list') }}" class="block text-center w-full bg-green-700 text-white py-3 rounded-xl font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20">
        Proses Kelayakan
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Dokumen Bantuan</h3>
        <p class="text-sm text-gray-500 mb-4">Memeriksa kelengkapan dan keaslian dokumen pendukung permohonan bantuan</p>
        <p class="text-green-700 font-medium mb-6">Menunggu: {{ $menunggu_dokumen }} Dokumen</p>
        <a href="{{ route('petugas.bantuan.dokumen.list') }}" class="block text-center w-full bg-green-700 text-white py-3 rounded-xl font-bold hover:bg-green-800 transition">
        Verifikasi Dokumen
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Verifikasi Kelayakan Permohonan</h3>
        <p class="text-xs text-gray-400 mt-1">Penjadwalan dan pelaksanaan survei untuk memeriksa lokasi benar-benar siap menerima bantuan.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b">
                    <th class="p-6">Pembudidaya</th>
                    <th class="p-6">Jenis Bantuan</th>
                    <th class="p-6">Jadwal Survei</th>
                    <th class="p-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($permohonan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $item->nama_pembudidaya }}</td>
                    <td class="p-6 text-sm text-gray-500">
                        {{ ucfirst($item->jenis_bantuan) }} {{ $item->detail_kebutuhan }}
                    </td>
                    <td class="p-6 text-sm text-gray-500">
                        @if($item->status_survei == 'sudah')
                            {{ $item->updated_at->format('Y-m-d') }}
                        @else
                            <span class="text-gray-400 italic">Belum Dijadwalkan</span>
                        @endif
                    </td>
                    <td class="p-6">
                        @if($item->status_survei == 'belum')
                            <button class="text-sm font-bold text-green-600 hover:text-green-800 transition">Jadwalkan</button>
                        @else
                            <button class="text-sm font-bold text-green-700 hover:text-green-900 transition">Verifikasi Detail</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-gray-400">Tidak ada permohonan bantuan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection