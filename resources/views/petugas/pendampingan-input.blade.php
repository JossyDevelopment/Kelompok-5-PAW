@extends('layouts.petugas')

@section('title', 'Imput Hasil & Dokumen')
@section('subtitle', 'Imput Hasil Pelaksana Pendamping')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <h3 class="text-lg font-bold text-gray-800 mb-6">Laporan Dokumentasi Pendamping</h3>

    <form action="{{ route('petugas.pendampingan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Pembudidaya:</label>
            <select name="id_pendampingan" required class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 bg-gray-50/50">
            <option value="">-- Pilih Pembudidaya & Topik --</option>
            @foreach($list_pendampingan as $p)
                {{-- Pastikan value adalah ID primary key dari tabel pengajuan_pendampingans --}}
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->topik }} (Jadwal: {{ \Carbon\Carbon::parse($p->jadwal_pendampingan)->format('d M Y') }} - Pukul {{ \Carbon\Carbon::parse($p->jam_kunjungan)->format('H:i') }} WIB)</option>
        @endforeach
    </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai Pelaksanaan:</label>
                <input type="date" name="tanggal_selesai" required 
                    class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 bg-white">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai Pelaksanaan:</label>
                <input type="time" name="jam_selesai" required 
                    class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 bg-white">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Hasil Pelaksana Pendamping:</label>
            <textarea name="hasil_pendampingan" rows="4" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Jelaskan poin-poin yang dibahas, masalah yang ditemukan, dan solusi yang diberikan"></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Upload Dokumentasi (Foto, Absen):</label>
            <div class="flex items-center gap-4">
                <input type="file" name="file_dokumentasi" id="fileInput" class="hidden">
                <label for="fileInput" class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm font-medium cursor-pointer hover:bg-green-100 transition">Pilih File</label>
                <span id="fileName" class="text-sm text-gray-400">Tidak ada file yang dipilih</span>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Rekomendasi Tindak Lanjut:</label>
            <textarea name="rekomendasi" rows="3" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Saran/tindakan yang harus dilakukan pembudidaya atau UPT kedepannya"></textarea>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold hover:bg-green-800 transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-file-contract"></i> Simpan Laporan Pendamping
        </button>
    </form>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>

<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : "Tidak ada file yang dipilih";
    });
</script>
@endsection