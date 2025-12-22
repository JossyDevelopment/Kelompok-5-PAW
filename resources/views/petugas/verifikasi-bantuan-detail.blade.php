@extends('layouts.petugas')

@section('title', 'Detail Verifikasi Kelayakan')

@section('content')
<div class="mb-6">
    <a href="{{ route('petugas.bantuan.list') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Permohonan
    </a>
    <div class="mt-4 flex justify-between items-end">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Permohonan: {{ $permohonan->jenis_bantuan }}</h2>
            <p class="text-sm text-gray-500">Oleh: {{ $permohonan->nama_pembudidaya }} (ID: {{ $permohonan->id_user }})</p>
            <p class="text-xs text-gray-400">Diajukan Pada: {{ $permohonan->created_at->format('d F Y') }}</p>
        </div>
        <span class="px-4 py-2 bg-amber-50 text-amber-700 text-xs font-bold rounded-lg border border-amber-100 uppercase">Menunggu Keputusan</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="space-y-6">
        <div class="bg-green-50/30 p-6 rounded-2xl border border-green-100">
            <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Informasi Bantuan</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Jenis Bantuan:</label>
                    <p class="text-sm font-bold text-gray-700">{{ $permohonan->jenis_bantuan }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Komoditas:</label>
                    <p class="text-sm font-bold text-gray-700">{{ $permohonan->komoditas }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Lokasi Usaha:</label>
                    <p class="text-sm font-bold text-gray-700">Desa {{ $permohonan->desa }}, Kec. {{ $permohonan->kecamatan }}</p>
                </div>
            </div>
        </div>
    </div>

   <div class="lg:col-span-2 space-y-6">
        <form action="{{ route('petugas.bantuan.kelayakan') }}" method="POST">
            @csrf
            <input type="hidden" name="id_permohonan" value="{{ $permohonan->id }}">

            {{-- Bagian Ceklis (Sesuai image_669e43.png) --}}
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Ceklis Kriteria Kelayakan (Persyaratan Mutlak)</h3>
                <div class="space-y-4">
                    @php 
                        $kriteria = [
                            '1. Pembudidaya terdaftar dan terverifikasi data identitas.',
                            '2. Hasil Survei Lapangan menyatakan lokasi dan usaha layak (Laporan tersedia).',
                            '3. Belum pernah menerima bantuan sejenis dalam 2 tahun terakhir.',
                            '4. Status kepemilikan lahan jelas dan sah (milik sendiri/sewa jangka panjang).'
                        ];
                    @endphp
                    @foreach($kriteria as $k)
                    <label class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer transition">
                        <input type="checkbox" class="mt-1 w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500" required>
                        <span class="text-sm text-gray-700 font-medium">{{ $k }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-center">
                    <p class="text-xs font-bold text-red-600 uppercase tracking-widest">Ringkasan: Pastikan semua kriteria terpenuhi</p>
                </div>
            </div>

            {{-- Bagian Keputusan --}}
            <div class="mt-6 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Keputusan Verifikasi Kelayakan</h3>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Pilih Keputusan Akhir:</label>
                    <select name="hasil_kelayakan" required class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none appearance-none bg-no-repeat bg-[right_1rem_center]">
                        <option value="disetujui">Direkomendasikan Lolos Kelayakan</option>
                        <option value="revisi">Perlu Revisi Lapangan</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Catatan Resmi Petugas (Wajib diisi):</label>
                    <textarea name="catatan_kelayakan" required rows="4" class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-green-500 outline-none" placeholder="Jelaskan alasan kelayakan atau penolakan berdasarkan kriteria di atas..."></textarea>
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold hover:bg-green-800 transition">
                    Terapkan Keputusan & Lanjutkan Verifikasi Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection