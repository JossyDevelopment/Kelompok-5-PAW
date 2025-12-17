@extends('layouts.pembudidaya')

@section('title', 'Jadwal & Feedback Pendampingan')
@section('subtitle', 'Lihat jadwal pendampingan yang telah disetujui dan berikan feedback untuk pendampingan yang sudah selesai.')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="font-bold text-gray-800 text-sm mb-4 uppercase tracking-wide">Jadwal Mendatang</h3>
    
    @forelse($jadwal_mendatang as $jadwal)
    <div class="border border-blue-200 bg-blue-50/30 rounded-lg p-4 mb-3">
        <h4 class="text-blue-700 font-bold text-sm mb-1">{{ $jadwal->topik }}</h4>
        <p class="text-xs text-gray-600">
            Petugas UPT: {{ $jadwal->petugas }} | Jadwal: {{ $jadwal->waktu }}
        </p>
        <span class="inline-block mt-2 px-2 py-0.5 bg-blue-100 text-blue-600 text-[10px] font-bold rounded">
            {{ $jadwal->status }}
        </span>
    </div>
    @empty
    <p class="text-sm text-gray-400 italic">Tidak ada jadwal pendampingan mendatang.</p>
    @endforelse
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="font-bold text-gray-800 text-sm mb-4 uppercase tracking-wide">Berikan Feedback</h3>

    <div class="space-y-4">
        @foreach($list_feedback as $item)
            
            @if($item['status'] == 'pending')
                <div id="card-{{ $item->id }}" class="border border-blue-200 bg-blue-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
                    <div class="w-full">
                        <h4 id="title-{{ $item->id }}" class="text-blue-700 font-bold text-sm">{{ $item->topik }}</h4>
                        <p class="text-xs text-gray-600 mt-1">
                            Selesai pada {{ $item->tanggal }}. {{ $item->pesan }}
                        </p>
                    </div>

                    <div id="action-area-{{ $item->id }}">
                        <button id="btn-feedback-{{ $item->id }}" onclick="bukaFormFeedback('{{ $item->id }}', '{{ $item->topik }}')" class="bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-800 transition shadow-sm w-full md:w-auto whitespace-nowrap">
                            Beri Feedback
                        </button>
                        
                        <span id="badge-selesai-{{ $item->id }}" class="hidden text-green-700 font-bold text-sm px-4 border border-green-200 bg-white rounded-full py-1">
                            <i class="fa-solid fa-check mr-1"></i> Sedang Diisi
                        </span>
                    </div>
                </div>

            @else
                <div class="border border-green-200 bg-green-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 opacity-75">
                    <div class="w-full">
                        <h4 class="text-green-700 font-bold text-sm">{{ $item->topik }}</h4>
                        <p class="text-xs text-gray-600 mt-1">
                            Selesai pada {{ $item->tanggal }}. {{ $item->pesan }}
                        </p>
                    </div>
                    <span class="text-green-700 font-bold text-sm px-4 border border-green-200 bg-white rounded-full py-1">
                        Feedback Diterima
                    </span>
                </div>
            @endif

        @endforeach
    </div>
</div>

<div id="section-form" class="hidden bg-white rounded-xl shadow-sm border border-gray-100 p-8 transition-all duration-500 ease-in-out">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
        <h3 class="font-bold text-gray-800 text-lg">
            Feedback Untuk Pendampingan <span id="text-kode-pend" class="text-blue-600"></span>
        </h3>
        <button onclick="tutupForm()" class="text-gray-400 hover:text-red-500 text-sm">
            <i class="fa-solid fa-xmark mr-1"></i> Batal
        </button>
    </div>

    <form action="#" method="POST">
        @csrf
        <input type="hidden" name="id_pendampingan" id="input-id-pend">
        <input type="hidden" name="rating" id="input-rating" value="0"> <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Berikan Penilaian Anda</label>
            <div class="flex gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <i onclick="setRating({{ $i }})" id="star-{{ $i }}" class="fa-regular fa-star text-3xl cursor-pointer text-gray-300 hover:text-orange-400 transition transform hover:scale-110"></i>
                @endfor
            </div>
            <p id="rating-text" class="text-xs text-gray-400 mt-2 font-medium">Klik bintang untuk menilai</p>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan & Hasil yang Dirasakan</label>
            <textarea name="ulasan" rows="3" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Contoh: Sangat membantu! Petugas UPT sangat kompeten. Penerapan saran langsung terlihat pada peningkatan kualitas air."></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition shadow-lg shadow-blue-600/30">
            Kirim Feedback
        </button>
    </form>
</div>

<script>
    let currentId = null;

    function bukaFormFeedback(id, judul) {
        // 1. Reset kartu sebelumnya jika ada
        if (currentId && currentId !== id) {
            resetKartu(currentId);
        }
        currentId = id;

        // 2. Ubah Tampilan Kartu (Biru -> Hijau)
        const card = document.getElementById(`card-${id}`);
        const title = document.getElementById(`title-${id}`);
        const btn = document.getElementById(`btn-feedback-${id}`);
        const badge = document.getElementById(`badge-selesai-${id}`);

        card.classList.remove('border-blue-200', 'bg-blue-50/50');
        card.classList.add('border-green-200', 'bg-green-50/50', 'ring-2', 'ring-green-500');

        title.classList.remove('text-blue-700');
        title.classList.add('text-green-700');

        btn.classList.add('hidden');
        badge.classList.remove('hidden');

        // 3. Siapkan Form
        document.getElementById('text-kode-pend').innerText = id; // Tampilkan ID di judul form
        document.getElementById('input-id-pend').value = id;
        
        // Reset Bintang setiap buka form baru
        setRating(0); 

        // 4. Munculkan Form
        const section = document.getElementById('section-form');
        section.classList.remove('hidden');
        setTimeout(() => {
            section.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300);
    }

    function resetKartu(id) {
        const card = document.getElementById(`card-${id}`);
        const title = document.getElementById(`title-${id}`);
        const btn = document.getElementById(`btn-feedback-${id}`);
        const badge = document.getElementById(`badge-selesai-${id}`);

        if(card) {
            card.classList.add('border-blue-200', 'bg-blue-50/50');
            card.classList.remove('border-green-200', 'bg-green-50/50', 'ring-2', 'ring-green-500');
            title.classList.add('text-blue-700');
            title.classList.remove('text-green-700');
            btn.classList.remove('hidden');
            badge.classList.add('hidden');
        }
    }

    function tutupForm() {
        document.getElementById('section-form').classList.add('hidden');
        if (currentId) {
            resetKartu(currentId);
            currentId = null;
        }
    }

    // --- LOGIKA BINTANG (STAR RATING) ---
    function setRating(rating) {
        document.getElementById('input-rating').value = rating; // Simpan ke input hidden
        
        // Update tampilan bintang
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star-${i}`);
            if (i <= rating) {
                // Bintang Aktif (Solid & Orange)
                star.classList.remove('fa-regular', 'text-gray-300');
                star.classList.add('fa-solid', 'text-orange-400');
            } else {
                // Bintang Mati (Regular & Gray)
                star.classList.remove('fa-solid', 'text-orange-400');
                star.classList.add('fa-regular', 'text-gray-300');
            }
        }

        // Update teks helper
        const texts = ["Klik bintang untuk menilai", "Sangat Buruk", "Buruk", "Cukup", "Baik", "Sangat Baik"];
        document.getElementById('rating-text').innerText = texts[rating];
        document.getElementById('rating-text').classList.add('text-orange-500');
    }
</script>

@endsection