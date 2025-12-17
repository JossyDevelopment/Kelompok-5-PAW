@extends('layouts.pembudidaya')

@section('title', 'Ajukan Permohonan Pendampingan Teknis')
@section('subtitle', 'Ajukan pendampingan teknis budidaya dari Petugas UPT untuk meningkatkan kualitas usaha Anda.')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

    <form action="{{ route('pembudidaya.pendampingan.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-800 mb-2">Pilih Topik Pendampingan <span class="text-red-500">*</span></label>
            <div class="relative">
                <select name="topik_pendampingan" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white text-gray-700 cursor-pointer">
                    <option value="" disabled selected>Pilih topik...</option>
                    <option value="kualitas_air" selected>Manajemen Kualitas Air</option>
                    <option value="pakan">Manajemen Pakan</option>
                    <option value="penyakit">Pengendalian Hama & Penyakit</option>
                    <option value="teknologi">Teknologi Budidaya (Bioflok/RAS)</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-800 mb-2">Jelaskan Kebutuhan Spesifik Pendampingan <span class="text-red-500">*</span></label>
            <textarea name="detail_kebutuhan" rows="5" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Contoh: Kami mengalami masalah fluktuasi pH yang tinggi. Membutuhkan panduan teknis untuk stabilisasi kualitas air pada tambak Udang Vaname."></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition shadow-lg shadow-blue-600/30">
            Ajukan Permohonan Pendampingan
        </button>

    </form>
</div>

@endsection