@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-8">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan & Statistik</h1>
            <p class="text-sm text-gray-400 font-medium">Sistem manajemen data pembudidaya perikanan</p>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-700 tracking-tight">Generate Laporan</h3>
            <button class="bg-purple-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-purple-100 hover:bg-purple-700 transition">
                <i class="fa-solid fa-file-export"></i> Export Semua
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $laporanTypes = [
                    ['title' => 'Laporan Kinerja UPT', 'desc' => 'Statistik lengkap efektivitas dan kualitas kerja petugas UPT.'],
                    ['title' => 'Laporan Pendataan', 'desc' => 'Statistik lengkap data dasar pembudidaya berdasarkan sebaran.'],
                    ['title' => 'Laporan Penyaluran Bantuan', 'desc' => 'Statistik lengkap realisasi dan distribusi bantuan.'],
                    ['title' => 'Laporan Evaluasi Pendampingan', 'desc' => 'Statistik lengkap hasil evaluasi.'],
                ];
            @endphp

            @foreach($laporanTypes as $lp)
            <div class="border border-gray-100 rounded-[32px] p-8 space-y-4 text-center hover:border-purple-200 transition group">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                    <i class="fa-solid fa-file-lines text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 leading-tight">{{ $lp['title'] }}</h4>
                <p class="text-[11px] text-gray-400 leading-relaxed">{{ $lp['desc'] }}</p>
                <button class="w-full mt-4 py-3 border-2 border-purple-600 text-purple-600 rounded-2xl text-xs font-black hover:bg-purple-600 hover:text-white transition uppercase tracking-widest">
                    <i class="fa-solid fa-download mr-2"></i> Download PDF
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
            <h3 class="text-lg font-bold text-gray-800">Ringkasan Bulanan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl">
                    <span class="text-sm font-bold text-gray-600">Pendaftar Baru</span>
                    <span class="text-sm font-bold text-blue-600">{{ $ringkasan['pendaftar_baru'] }} pembudidaya</span>
                </div>
                <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl">
                    <span class="text-sm font-bold text-gray-600">Verifikasi Selesai</span>
                    <span class="text-sm font-bold text-green-600">{{ $ringkasan['verifikasi_selesai'] }} verifikasi</span>
                </div>
                <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl">
                    <span class="text-sm font-bold text-gray-600">Tingkat Approval</span>
                    <span class="text-sm font-bold text-purple-600">{{ $ringkasan['tingkat_approval'] }}%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
            <h3 class="text-lg font-bold text-gray-800">Top Komoditas Bulan Ini</h3>
            <div class="space-y-4">
                @foreach($topKomoditas as $index => $k)
                <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl">
                    <div class="flex items-center gap-4">
                        <span class="w-8 h-8 bg-white border border-gray-100 rounded-full flex items-center justify-center text-xs font-black text-gray-400 shadow-sm">{{ $index + 1 }}</span>
                        <span class="text-sm font-bold text-gray-800">{{ $k['nama'] }}</span>
                    </div>
                    <span class="text-sm font-bold text-orange-500">{{ $k['jumlah'] }} unit</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection