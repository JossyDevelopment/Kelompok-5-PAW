@extends('layouts.petugas')

@section('content')
<div class="mb-8">
    <a href="{{ route('petugas.bantuan.dokumen.list') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Permohonan
    </a>
    <h2 class="text-xl font-bold text-gray-800 mt-4">Detail Verifikasi Kelayakan Permohonan Bantuan</h2>
    <p class="text-sm text-gray-500">Permohonan: Bantuan {{ $permohonan->jenis_bantuan }} | Oleh: {{ $permohonan->nama_pembudidaya }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-green-50/40 p-6 rounded-2xl border border-green-100 h-fit">
        <h3 class="text-sm font-bold text-gray-800 uppercase mb-4">Informasi Bantuan</h3>
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
                <p class="text-sm font-bold text-gray-700">Ds. {{ $permohonan->desa }}, Kab. Sidoarjo</p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 uppercase mb-6">Daftar Dokumen yang Diajukan (Wajib)</h3>
            
            @php $docs = ['Salinan KTP Pemohon', 'Surat Keterangan Usaha Budidaya (SKU)', 'Foto Lokasi Usaha Budidaya']; @endphp
            
            @foreach($docs as $index => $doc)
            <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                <div>
                    <p class="text-sm font-bold text-gray-700">{{ $index+1 }}. {{ $doc }}</p>
                    <div class="mt-3 flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="doc_{{$index}}" class="w-4 h-4 text-green-600">
                            <span class="text-xs font-bold text-gray-600">Diterima</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="doc_{{$index}}" class="w-4 h-4 text-red-600">
                            <span class="text-xs font-bold text-gray-600">Ditolak</span>
                        </label>
                    </div>
                </div>
                <button class="px-4 py-2 bg-green-700 text-white text-[10px] font-bold rounded-lg">Lihat Dokumen</button>
            </div>
            @endforeach
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('petugas.bantuan.dokumen.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $permohonan->id }}">
                <h3 class="text-sm font-bold text-gray-800 uppercase mb-4">Keputusan Akhir Verifikasi Dokumen</h3>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Keputusan</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="disetujui_admin">Direkomendasikan Lolos Kelayakan</option>
                        <option value="revisi">Perlu Perbaikan Dokumen</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Catatan Verifikasi (Wajib diisi):</label>
                    <textarea name="catatan" rows="3" class="w-full border border-gray-200 rounded-xl p-3 text-sm" placeholder="Ringkasan hasil verifikasi..."></textarea>
                </div>

                <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold hover:bg-green-800 transition">
                    Selesaikan Verifikasi Dokumen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection