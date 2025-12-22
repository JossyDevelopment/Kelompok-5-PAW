@extends('layouts.petugas')

@section('title', 'Penyaluran & Distribusi')
@section('subtitle', 'Proses Penyaluran Bantuan')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">1. Input Data Distribusi Bantuan</h3>
        <form action="{{ route('petugas.penyaluran.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Penerima (Siap Kirim):</label>
                <select name="id_permohonan" id="selectPenerima" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 bg-gray-50/50" required>
                    <option value="">Cari nama pembudidaya</option>
                    @forelse($penerima as $p)
                        <option value="{{ $p->id }}" data-bantuan="{{ ucfirst($p->jenis_bantuan) }}">
                            {{ $p->nama ?? 'User ID: '.$p->id_user . ' (Profil Belum Diisi)' }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada data dengan status 'disetujui_admin'</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Bantuan:</label>
                <input type="text" id="displayBantuan" class="w-full border border-gray-300 rounded-xl p-3 text-sm bg-gray-100" readonly placeholder="Otomatis terisi...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Penyaluran:</label>
                <input type="date" name="tanggal_penyaluran" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500" required>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-xl font-bold hover:bg-green-800 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data Distribusi
            </button>
        </form>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-2">2. Unggah Berita Acara Serah Terima (BAST)</h3>
        <p class="text-sm text-gray-500 mb-6">Pilih penerima yang sudah dikirim bantuannya untuk menyelesaikan proses.</p>
        <form action="{{ route('petugas.penyaluran.bast') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Penerima BAST:</label>
                <select name="id_permohonan" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 bg-gray-50/50" required>
                    <option value="">Pilih nama pembudidaya</option>
                    @forelse($penerima_bast as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }} ({{ ucfirst($p->jenis_bantuan) }})</option>
                    @empty
                        <option value="" disabled>Belum ada data distribusi berstatus 'dikirim'</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Bukti BAST (.JPG/.PNG)</label>
                <input type="file" name="file_bast" id="fileBast" class="hidden" required accept="image/*">
                <label for="fileBast" class="block w-full text-center py-4 border-2 border-dashed border-green-200 rounded-xl cursor-pointer hover:bg-green-50 transition">
                    <span id="fileName" class="text-sm text-green-700 font-medium italic">Klik untuk pilih foto bukti terima</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-xl font-bold hover:bg-green-800 transition">
                <i class="fa-solid fa-upload"></i> Selesaikan Penyaluran & Unggah Bukti
            </button>
        </form>
    </div>
</div>

<script>
    // Logic auto-fill jenis bantuan saat Nama Penerima dipilih
    document.getElementById('selectPenerima').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const bantuan = selectedOption.getAttribute('data-bantuan');
        document.getElementById('displayBantuan').value = bantuan || '';
    });

    // Logic menampilkan nama file yang dipilih
    document.getElementById('fileBast').addEventListener('change', function() {
        document.getElementById('fileName').innerText = this.files[0] ? 'File terpilih: ' + this.files[0].name : 'Klik untuk pilih foto bukti terima';
    });
</script>
@endsection