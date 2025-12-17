@extends('layouts.pembudidaya')

@section('title', 'Konfirmasi Penerimaan Bantuan')
@section('subtitle', 'Konfirmasi penerimaan bantuan yang telah Anda terima ini adalah langkah terakhir untuk menyelesaikan proses bantuan')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="font-bold text-gray-800 text-sm mb-4 uppercase tracking-wide">Bantuan Siap Dikonfirmasi</h3>

    <div class="space-y-4">
        @foreach($daftar_bantuan as $item)
            
            @if($item['status'] == 'pending')
                <div id="card-{{ $item['kode'] }}" class="border border-blue-200 bg-blue-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
                    
                    <div class="flex items-start gap-3 w-full">
                        <div id="icon-{{ $item['kode'] }}" class="text-blue-600 mt-1">
                            <i class="fa-solid fa-circle-question text-lg"></i>
                        </div>
                        <div>
                            <h4 id="title-{{ $item['kode'] }}" class="text-blue-700 font-bold text-sm">{{ $item->kode }}: {{ $item->nama }}</h4>
                            <p class="text-xs text-gray-600 mt-1">
                                Telah tiba di lokasi pada {{ $item->tanggal }}. {{ $item->pesan }}
                            </p>
                        </div>
                    </div>

                    <div id="action-area-{{ $item->kode }}">
                        
                        <button id="btn-konfirmasi-{{ $item->kode }}" onclick="pilihBantuan('{{ $item->kode }}')" class="bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-800 transition shadow-sm w-full md:w-auto">
                            Konfirmasi
                        </button>

                        <span id="badge-selesai-{{ $item->kode }}" class="hidden text-green-700 font-bold text-sm px-4 border border-green-200 bg-white rounded-full py-1">
                            <i class="fa-solid fa-check mr-1"></i> Dikonfirmasi
                        </span>

                    </div>
                </div>
            
            @else
                <div class="border border-green-200 bg-green-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 opacity-75">
                    <div class="flex items-start gap-3 w-full">
                        <div class="text-green-600 mt-1">
                            <i class="fa-regular fa-circle-check text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-green-700 font-bold text-sm">{{ $item->kode }}: {{ $item->nama }}</h4>
                            <p class="text-xs text-gray-600 mt-1">
                                Telah tiba di lokasi pada {{ $item->tanggal }}. {{ $item->pesan }}
                            </p>
                        </div>
                    </div>
                    <span class="text-green-700 font-bold text-sm px-4 border border-green-200 bg-white rounded-full py-1">
                        Dikonfirmasi
                    </span>
                </div>
            @endif

        @endforeach
    </div>
</div>

<div id="section-form" class="hidden bg-white rounded-xl shadow-sm border border-gray-100 p-8 transition-all duration-500 ease-in-out">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
        <h3 class="font-bold text-gray-800 text-lg">
            Form Konfirmasi Penerimaan <span id="text-kode-bantuan" class="text-blue-600"></span>
        </h3>
        
        <button onclick="batalKonfirmasi()" class="text-gray-400 hover:text-red-500 text-sm">
            <i class="fa-solid fa-xmark mr-1"></i> Batal
        </button>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="kode_tiket" id="input-kode-tiket">

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Penerimaan Aktual</label>
            <input type="date" name="tanggal_terima" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Penerimaan (Opsional)</label>
            <textarea name="catatan" rows="3" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Contoh: Barang diterima dalam kondisi baik."></textarea>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-700 mb-2">Upload Foto Bukti Penerimaan (.JPG)</label>
            <div class="flex items-center gap-4">
                <label class="cursor-pointer bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 font-bold py-2 px-6 rounded-lg text-sm transition">
                    Pilih file
                    <input type="file" name="foto_bukti" class="hidden" onchange="previewFileName(this)">
                </label>
                <span id="file-name-display" class="text-sm text-gray-500">Tidak ada file yang dipilih</span>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition shadow-lg shadow-blue-600/30">
            Kirim Konfirmasi Akhir
        </button>
    </form>
</div>

<script>
    let currentKode = null; // Menyimpan kode yang sedang diedit

    function pilihBantuan(kode) {
        // 1. Jika ada kartu lain yang sedang aktif, kembalikan ke warna biru dulu (Reset)
        if (currentKode && currentKode !== kode) {
            resetTampilanKartu(currentKode);
        }
        
        currentKode = kode;

        // 2. Ubah Tampilan Kartu Menjadi "Hijau/Dikonfirmasi" Secara Visual
        const card = document.getElementById(`card-${kode}`);
        const icon = document.getElementById(`icon-${kode}`);
        const title = document.getElementById(`title-${kode}`);
        const btn = document.getElementById(`btn-konfirmasi-${kode}`);
        const badge = document.getElementById(`badge-selesai-${kode}`);

        // Ganti class CARD (Biru -> Hijau)
        card.classList.remove('border-blue-200', 'bg-blue-50/50');
        card.classList.add('border-green-200', 'bg-green-50/50', 'ring-2', 'ring-green-500'); // Tambah ring biar highlight

        // Ganti class ICON
        icon.classList.remove('text-blue-600');
        icon.classList.add('text-green-600');
        icon.innerHTML = '<i class="fa-regular fa-circle-check text-lg"></i>'; // Ganti icon ? jadi Check

        // Ganti class TITLE
        title.classList.remove('text-blue-700');
        title.classList.add('text-green-700');

        // Ganti TOMBOL jadi BADGE
        btn.classList.add('hidden'); // Sembunyikan tombol
        badge.classList.remove('hidden'); // Munculkan badge 'Dikonfirmasi'

        // 3. Tampilkan Form di Bawah
        openForm(kode);
    }

    function resetTampilanKartu(kode) {
        // Kembalikan kartu ke kondisi awal (Biru) jika user pindah klik ke kartu lain
        const card = document.getElementById(`card-${kode}`);
        const icon = document.getElementById(`icon-${kode}`);
        const title = document.getElementById(`title-${kode}`);
        const btn = document.getElementById(`btn-konfirmasi-${kode}`);
        const badge = document.getElementById(`badge-selesai-${kode}`);

        if(card) {
            card.classList.add('border-blue-200', 'bg-blue-50/50');
            card.classList.remove('border-green-200', 'bg-green-50/50', 'ring-2', 'ring-green-500');

            icon.classList.add('text-blue-600');
            icon.classList.remove('text-green-600');
            icon.innerHTML = '<i class="fa-solid fa-circle-question text-lg"></i>';

            title.classList.add('text-blue-700');
            title.classList.remove('text-green-700');

            btn.classList.remove('hidden');
            badge.classList.add('hidden');
        }
    }

    function openForm(kode) {
        const section = document.getElementById('section-form');
        document.getElementById('text-kode-bantuan').innerText = kode;
        document.getElementById('input-kode-tiket').value = kode;
        
        section.classList.remove('hidden');
        // Scroll halus ke form
        setTimeout(() => {
            section.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300);
    }

    function batalKonfirmasi() {
        // Sembunyikan form
        document.getElementById('section-form').classList.add('hidden');
        // Kembalikan kartu yang sedang aktif ke warna biru
        if (currentKode) {
            resetTampilanKartu(currentKode);
            currentKode = null;
        }
    }

    function previewFileName(input) {
        const display = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            display.innerText = input.files[0].name;
            display.classList.add('text-green-600', 'font-medium');
        } else {
            display.innerText = "Tidak ada file yang dipilih";
        }
    }
</script>

@endsection