@extends('layouts.pembudidaya')

@section('title', 'Ajukan Permohonan Bantuan')
@section('subtitle', 'Pilih jenis bantuan yang anda butuhkan (Benih/Pakan/Alat) dan lengkapi dokumen pendukung.')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

    <form action="{{ route('pembudidaya.ajukan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-800 mb-3">Jenis Bantuan yang Diajukan <span class="text-red-500">*</span></label>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <label class="cursor-pointer relative">
                    <input type="radio" name="jenis_bantuan" value="benih" class="peer sr-only" checked>
                    <div class="p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 flex items-center gap-3">
                        <div class="w-5 h-5 rounded border border-gray-300 peer-checked:bg-blue-500 peer-checked:border-blue-500 flex items-center justify-center text-white text-xs">
                           <i class="fa-solid fa-check opacity-0 peer-checked:opacity-100"></i> 
                        </div>
                        <i class="fa-solid fa-fish text-lg text-blue-500"></i>
                        <span class="font-semibold text-sm">Benih Ikan</span>
                    </div>
                    <div class="absolute top-5 left-5 text-white text-xs opacity-0 peer-checked:opacity-100">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

                <label class="cursor-pointer relative">
                    <input type="radio" name="jenis_bantuan" value="pakan" class="peer sr-only">
                    <div class="p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 flex items-center gap-3">
                        <div class="w-5 h-5 rounded border border-gray-300 peer-checked:bg-blue-500 peer-checked:border-blue-500"></div> 
                        <i class="fa-solid fa-cookie-bite text-lg text-orange-500"></i>
                        <span class="font-semibold text-sm">Pakan Ikan</span>
                    </div>
                     <div class="absolute top-5 left-5 text-white text-xs opacity-0 peer-checked:opacity-100">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

                <label class="cursor-pointer relative">
                    <input type="radio" name="jenis_bantuan" value="alat" class="peer sr-only">
                    <div class="p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 flex items-center gap-3">
                        <div class="w-5 h-5 rounded border border-gray-300 peer-checked:bg-blue-500 peer-checked:border-blue-500"></div>
                        <i class="fa-solid fa-toolbox text-lg text-gray-500"></i>
                        <span class="font-semibold text-sm">Alat Budidaya</span>
                    </div>
                     <div class="absolute top-5 left-5 text-white text-xs opacity-0 peer-checked:opacity-100">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-800 mb-2">Detail Kebutuhan <span class="text-red-500">*</span></label>
            <textarea name="detail_kebutuhan" rows="4" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Jelaskan kebutuhan spesifik anda, Contoh: Benih Udang Vaname PL-12 sejumlah 50.000 ekor."></textarea>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-800 mb-1">Upload Dokumen Pendukung <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-4">Pastikan dokumen (misalnya: Surat Permohonan, KTP/KK, Surat Keterangan Usaha) Diunggah dalam format PDF/JPG</p>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Surat Permohonan Resmi (.PDF)</label>
                    <input type="file" name="file_permohonan" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-green-50 file:text-green-700
                        file:cursor-pointer hover:file:bg-green-100
                    "/>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dokumen Legalitas Usaha (.PDF/.JPG)</label>
                    <input type="file" name="file_legalitas" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-green-50 file:text-green-700
                        file:cursor-pointer hover:file:bg-green-100
                    "/>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
            Kirim Permohonan Bantuan
        </button>

    </form>
</div>

<style>
    /* Ketika radio checked, cari elemen anak .w-5 lalu ubah backgroundnya */
    input:checked + div .w-5 {
        background-color: #3b82f6; /* Blue 500 */
        border-color: #3b82f6;
    }
</style>

@endsection