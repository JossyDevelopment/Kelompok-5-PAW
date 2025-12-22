@extends('layouts.petugas')

@section('content')
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800">Daftar Permohonan Verifikasi Dokumen Bantuan</h3>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <a href="{{ route('petugas.bantuan.index') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2 mb-6">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Ringkasan Tugas
        </a>
        <input type="text" placeholder="Cari Permohonan" class="w-full md:w-96 pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50/50">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-6">PEMBUDIDAYA</th>
                    <th class="p-6">JENIS BANTUAN</th>
                    <th class="p-6">JADWAL SURVEI</th>
                    <th class="p-6">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($permohonan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $item->nama_pembudidaya }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ ucfirst($item->jenis_bantuan) }}</td>
                    <td class="p-6 text-sm text-green-600 font-bold italic">Sudah Diverifikasi Lapangan</td>
                    <td class="p-6">
                        <a href="{{ route('petugas.bantuan.dokumen.detail', $item->id) }}" class="text-sm font-bold text-green-700 hover:text-green-900 transition">
                            Verifikasi
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection