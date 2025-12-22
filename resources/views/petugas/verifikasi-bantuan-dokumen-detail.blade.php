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
            <h3 class="text-sm font-bold text-gray-800 uppercase mb-6 tracking-wider">Daftar Dokumen yang Diajukan (Wajib)</h3>
            
            @php $docs = ['Salinan KTP Pemohon', 'Surat Keterangan Usaha Budidaya (SKU)', 'Foto Lokasi Usaha Budidaya']; @endphp
            @foreach($docs as $index => $doc)
            <div class="flex items-center justify-between py-6 border-b border-gray-50 last:border-0">
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-700">{{ $index+1 }}. {{ $doc }}</p>
                    <div class="mt-4 flex gap-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="doc_{{$index}}" value="diterima" class="w-4 h-4 text-green-600 focus:ring-green-500" required>
                            <span class="text-xs font-bold text-gray-600">Diterima</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="doc_{{$index}}" value="ditolak" class="w-4 h-4 text-red-600 focus:ring-red-500">
                            <span class="text-xs font-bold text-gray-600">Ditolak</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="doc_{{$index}}" value="revisi" class="w-4 h-4 text-orange-500 focus:ring-orange-400">
                            <span class="text-xs font-bold text-gray-600">Perlu Perbaikan</span>
                        </label>
                    </div>
                </div>
                <button class="px-5 py-2.5 bg-green-700 text-white text-[10px] font-bold rounded-lg shadow-sm hover:bg-green-800 transition">Lihat Dokumen</button>
            </div>
            @endforeach
            
            {{-- Summary Box (Sesuai Screenshot) --}}
            <div class="mt-6 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                <p class="text-[11px] text-amber-700 leading-relaxed">
                    Ringkasan: Silakan tinjau semua dokumen di atas. Verifikasi belum selesai hingga keputusan akhir diambil.
                </p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('petugas.bantuan.dokumen.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $permohonan->id }}">
                <h3 class="text-sm font-bold text-gray-800 uppercase mb-4 tracking-wider">Keputusan Akhir Verifikasi Dokumen</h3>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-tighter">Keputusan</label>
                    <select name="status" required class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none appearance-none">
                        <option value="disetujui_admin">Direkomendasikan Lolos Kelayakan</option>
                        <option value="revisi">Perlu Perbaikan Dokumen</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Catatan Verifikasi (Wajib diisi):</label>
                    <textarea name="catatan" required rows="3" class="w-full border border-gray-200 rounded-xl p-4 text-sm" placeholder="Ringkasan hasil verifikasi dan langkah selanjutnya..."></textarea>
                </div>

                <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20">
                    Selesaikan Verifikasi Dokumen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection