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
        <form action="{{ route('petugas.bantuan.selesai') }}" method="POST">
            @csrf
            <input type="hidden" name="id_permohonan" value="{{ $permohonan->id }}">

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm space-y-8">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Daftar Dokumen yang Diajukan (Wajib)</h3>
                
                @php $docs = ['Salinan KTP Pemohon', 'Surat Keterangan Usaha (SKU)', 'Foto Lokasi Usaha']; @endphp
                
                @foreach($docs as $index => $doc)
                <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-700">{{ $index + 1 }}. {{ $doc }}</p>
                        <div class="mt-3 flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="doc_{{ $index }}" value="diterima" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" required>
                                <span class="text-xs font-bold text-gray-600">Diterima</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="doc_{{ $index }}" value="ditolak" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                <span class="text-xs font-bold text-gray-600">Ditolak</span>
                            </label>
                        </div>
                    </div>
                    <button type="button" class="px-4 py-2 bg-green-700 text-white text-[10px] font-bold rounded-lg hover:bg-green-800 transition">Lihat Dokumen</button>
                </div>
                @endforeach
            </div>

            <div class="mt-8 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Keputusan Akhir Verifikasi Dokumen</h3>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Keputusan</label>
                    <select name="keputusan_akhir" required class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="direkomendasikan">Direkomendasikan Lolos Kelayakan</option>
                        <option value="revisi">Perlu Perbaikan Dokumen</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Catatan Verifikasi (Wajib diisi):</label>
                    <textarea name="catatan_verifikasi" required rows="4" class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-green-500 outline-none" placeholder="Ringkasan hasil verifikasi..."></textarea>
                </div>

                <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20">
                    Selesaikan Verifikasi Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection