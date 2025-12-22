@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-6">
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Data Master</h1>
        <p class="text-sm text-gray-400 font-medium">Sistem manajemen data pembudidaya perikanan</p>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex gap-2">
        <a href="{{ route('admin.master.komoditas') }}" 
        class="px-6 py-2 rounded-xl text-sm font-bold transition-all 
        {{ request()->routeIs('admin.master.komoditas') ? 'bg-purple-600 text-white shadow-lg shadow-purple-100' : 'text-gray-500 hover:bg-gray-50 border border-gray-100' }}">
        Jenis Komoditas
        </a>
        <a href="{{ route('admin.master.wilayah') }}" class="px-6 py-2 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 border border-gray-100 transition">Wilayah</a>
        <a href="{{ route('admin.master.jenis_bantuan') }}" class="px-6 py-2 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 border border-gray-100 transition">Jenis Bantuan</a>
        <a href="{{ route('admin.master.topik') }}" class="px-6 py-2 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 border border-gray-100 transition">Topik Teknis Pendamping</a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Data Master Jenis Komoditas</h3>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form action="{{ route('admin.master.komoditas') }}" method="GET" class="relative flex-1">
                    <input type="text" name="search" placeholder="Cari Komoditas..." class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-purple-500 bg-gray-50/50">
                </form>
                <button onclick="openModal()" class="bg-purple-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-purple-700 transition shrink-0 shadow-lg shadow-purple-100">
                    <i class="fa-solid fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-5">NO</th>
                        <th class="px-8 py-5">NAMA</th>
                        <th class="px-8 py-5">STATUS</th>
                        <th class="px-8 py-5 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($komoditas as $index => $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-8 py-5 text-sm font-bold text-gray-600">{{ $komoditas->firstItem() + $index }}</td>
                        <td class="px-8 py-5 text-sm font-bold text-gray-700">{{ $item->nama }}</td>
                        <td class="px-8 py-5">
                            <span class="px-4 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full border border-green-100">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama }}')" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center border border-blue-100">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.master.komoditas.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button onclick="confirmDelete({{ $item->id }})" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center border border-red-100">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-10 text-center text-gray-400 italic">Data Komoditas belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-gray-50/30 border-t border-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-400 font-medium">Menampilkan {{ $komoditas->firstItem() }} - {{ $komoditas->lastItem() }} dari {{ $komoditas->total() }} Data</p>
            {{ $komoditas->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<div id="modalTambah" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 tracking-tight">Tambah Jenis Komoditas</h3>
            </div>

            <form action="{{ route('admin.master.komoditas.store') }}" method="POST">
                @csrf
                <div class="p-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Nama Komoditas</label>
                        <input type="text" name="nama" required 
                               class="w-full border border-gray-200 rounded-2xl p-4 text-sm focus:ring-2 focus:ring-purple-500 outline-none transition bg-gray-50/30" 
                               placeholder="Masukkan nama komoditas">
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50/50 flex gap-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" 
                            class="flex-1 px-6 py-4 border border-gray-300 rounded-2xl text-sm font-bold text-gray-600 hover:bg-white transition uppercase tracking-widest">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-4 bg-purple-600 text-white rounded-2xl text-sm font-bold hover:bg-purple-700 transition shadow-lg shadow-purple-900/20 uppercase tracking-widest">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEdit" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 tracking-tight">Edit Data Master</h3>
            </div>

            {{-- Action akan di-set via JavaScript --}}
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk method update --}}
                <div class="p-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Nama Komoditas</label>
                        {{-- ID editNama digunakan untuk mengisi nilai via JS --}}
                        <input type="text" id="editNama" name="nama" required
                               class="w-full border border-gray-200 rounded-2xl p-4 text-sm focus:ring-2 focus:ring-purple-500 outline-none transition bg-gray-50/30"
                               placeholder="Masukkan nama komoditas">
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50/50 flex gap-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()"
                            class="flex-1 px-6 py-4 border border-gray-300 rounded-2xl text-sm font-bold text-gray-600 hover:bg-white transition uppercase tracking-widest">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-purple-600 text-white rounded-2xl text-sm font-bold hover:bg-purple-700 transition shadow-lg shadow-purple-900/20 uppercase tracking-widest">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalHapus" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-gray-100 text-center">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-2xl font-black text-orange-500 tracking-widest uppercase">PERINGATAN!!!</h3>
            </div>

            <div class="p-8 space-y-6">
                <div class="flex justify-center">
                    <div class="w-24 h-24 text-orange-500 border-4 border-orange-500 rounded-2xl flex items-center justify-center rotate-45 overflow-hidden">
                        <i class="fa-solid fa-exclamation text-5xl -rotate-45"></i>
                    </div>
                </div>

                <p class="text-xl font-bold text-gray-700">Anda yakin ingin menghapus Data Ini?</p>
            </div>

            <div class="px-8 py-6 bg-gray-50/50 flex gap-4 border-t border-gray-100">
                <button type="button" onclick="closeDeleteModal()" 
                        class="flex-1 px-6 py-4 border border-gray-300 rounded-2xl text-sm font-bold text-gray-600 hover:bg-white transition">
                    Batal
                </button>
                
                {{-- Form tersembunyi yang akan dikirim saat klik "Ya, Hapus" --}}
                <form id="formHapusData" action="" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-6 py-4 bg-orange-500 text-white rounded-2xl text-sm font-bold hover:bg-orange-600 transition shadow-lg shadow-orange-200 uppercase tracking-wider">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalSuccess" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-sm p-12 transform transition-all text-center">
            <div class="flex justify-center mb-8">
                <div class="w-24 h-24 bg-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-purple-200">
                    <i class="fa-solid fa-check text-5xl text-white"></i>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 tracking-tight" id="successMessage">
                {{ session('success_crud') }}
            </h3>
        </div>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('modalTambah');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
    }

    function closeModal() {
        const modal = document.getElementById('modalTambah');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
    }

    function openEditModal(id, nama) {
        const modal = document.getElementById('modalEdit');
        const form = document.getElementById('formEdit');
        const inputNama = document.getElementById('editNama');

        // 1. Isi field input dengan data nama yang lama
        inputNama.value = nama;

        // 2. Generate URL update yang dinamis berdasarkan ID
        // Kita pakai placeholder '0' dulu, lalu replace dengan ID yang sebenarnya
        let url = "{{ route('admin.master.komoditas.update', 0) }}";
        form.action = url.replace('/0/', '/' + id + '/');

        // 3. Tampilkan modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('modalEdit');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Update event listener untuk menutup modal saat klik di luar area
    window.onclick = function(event) {
        const modalTambah = document.getElementById('modalTambah');
        const modalEdit = document.getElementById('modalEdit');
        if (event.target == modalTambah) {
            closeModal();
        }
        if (event.target == modalEdit) {
            closeEditModal();
        }
    }

    function confirmDelete(id) {
        const modal = document.getElementById('modalHapus');
        const form = document.getElementById('formHapusData');
        
        // Atur URL Action Form secara dinamis
        let url = "{{ route('admin.master.komoditas.destroy', 0) }}";
        form.action = url.replace('/0', '/' + id);

        // Tampilkan modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('modalHapus');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success_crud'))
            showSuccessModal();
        @endif
    });

    function showSuccessModal() {
        const modal = document.getElementById('modalSuccess');
        
        // Munculkan modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Otomatis tutup setelah 2 detik (2000ms)
        setTimeout(() => {
            closeSuccessModal();
        }, 2000);
    }

    function closeSuccessModal() {
        const modal = document.getElementById('modalSuccess');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection