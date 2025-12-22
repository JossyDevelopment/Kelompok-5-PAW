@extends('layouts.petugas')

@section('title', 'Verifikasi Pembudidaya')
@section('subtitle', 'Verifikasi Data dan Usaha Budidaya')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Verifikasi Data Pembudidaya</h3>
            <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                Memeriksa Kelayakan dan keabsahan data identitas (KTP, Domisili)
            </p>
            <p class="text-gray-600 font-medium mb-6">
                Status: <span class="text-gray-800 font-bold">{{ $stats['permohonan_baru'] }} Permohonan Baru</span>
            </p>
        </div>
        <a href="{{ route('petugas.verifikasi.list') }}" class="w-full text-center bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-lg transition shadow-md shadow-green-700/20 text-sm">
        Mulai Verifikasi
    </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Validasi Detail Usaha</h3>
            <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                Memeriksa jenis, skala, lokasi, dan izin usaha budidaya
            </p>
            <p class="text-gray-600 font-medium mb-6">
                Status: <span class="text-gray-800 font-bold">{{ $stats['menunggu_validasi'] }} Menunggu Validasi</span>
            </p>
        </div>
        <a href="{{ route('petugas.validasi.list') }}" class="w-full text-center bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-lg transition shadow-md shadow-green-700/20 text-sm">
        Lihat Detail
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Melakukan Survei Lapangan</h3>
            <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                Kunjungan fisik untuk mencocokan data yang diajukan dengan kondisi aktual.
            </p>
            <p class="text-gray-600 font-medium mb-6">
                Status: <span class="text-gray-800 font-bold">{{ $stats['perlu_dijadwalkan'] }} Perlu Dijadwalkan</span>
            </p>
        </div>
       <a href="{{ route('petugas.survei.list') }}" class="w-full text-center bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-lg transition shadow-md shadow-green-700/20 text-sm">
        Jadwal Survei
        </a>
    </div>

</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    <h3 class="font-bold text-gray-800 text-base mb-4">Catatan/Feedback Verifikasi</h3>
    <p class="text-sm text-gray-600 mb-4">
        Input catatan penting atau feedback yang diberikan kepada pembudidaya terkait hasil verifikasi data.
    </p>

    <form action="#" method="POST">
        @csrf
        <div class="mb-6">
            <textarea name="catatan_verifikasi" rows="4" class="w-full border border-gray-300 rounded-lg p-4 text-sm focus:ring-green-500 focus:border-green-500 placeholder-gray-400 bg-gray-50/50" placeholder="Masukan catatan verifikasi atau feedback di sini..."></textarea>
        </div>

        <div class="flex gap-4">
            <button type="button" class="px-6 py-2.5 rounded-lg border border-green-600 text-green-700 font-bold text-sm hover:bg-green-50 transition">
                Tandai Selesai
            </button>

            <button type="submit" class="px-6 py-2.5 rounded-lg bg-green-700 text-white font-bold text-sm hover:bg-green-800 transition shadow-md shadow-green-700/20">
                Kirim Feedback
            </button>
        </div>
    </form>
</div>

@endsection