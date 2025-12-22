@extends('layouts.petugas')

@section('title', 'Verifikasi Pembudidaya')
@section('subtitle', 'Verifikasi Data dan Usaha Budidaya')

@section('content')
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800">Jadwal Survei Lapangan</h3>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl text-sm font-bold flex items-center gap-3">
    <i class="fa-solid fa-circle-check"></i>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('petugas.verifikasi') }}" class="text-sm text-gray-500 hover:text-green-700 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Ringkasan Tugas
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative w-full md:w-96">
                <input type="text" placeholder="Cari Permohonan" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 bg-gray-50/50">
            </div>
            <button class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-green-800 transition shadow-md shadow-green-700/20">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-6">NAMA</th>
                    <th class="p-6">LOKASI & PEMBUDIDAYA</th>
                    <th class="p-6">TGL PENGAJUAN</th>
                    <th class="p-6">STATUS</th>
                    <th class="p-6">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pembudidaya as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-6 text-sm text-gray-700 font-medium">{{ $user->nama_lengkap }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ $user->alamat ?? 'Lokasi belum diisi' }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="p-6">
                        @if($user->status_survei == 'sudah')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg border border-green-200 uppercase">Sudah Dijadwalkan</span>
                        @else
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg border border-amber-200 uppercase">Belum Dijadwalkan</span>
                        @endif
                    </td>
                    <td class="p-6">
                        <div class="flex gap-4">
                            @if($user->status_survei == 'sudah')
                                <form action="{{ route('petugas.jadwal.cancel') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal survei untuk {{ $user->nama_lengkap }}?')">
                                    @csrf
                                    <input type="hidden" name="id_user" value="{{ $user->id_user }}">
                                    <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition flex items-center gap-1">
                                        <i class="fa-solid fa-xmark"></i> Batalkan
                                    </button>
                                </form>
                            @else
                                <button 
                                    onclick="openScheduleModal('{{ $user->id_user }}', '{{ $user->nama_lengkap }}', '{{ $user->desa }}, {{ $user->kecamatan }}')"
                                    class="text-sm font-bold text-green-700 hover:text-green-900 transition flex items-center gap-1">
                                    <i class="fa-regular fa-calendar-plus"></i> Jadwalkan
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">Tidak ada jadwal survei.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-6 bg-white border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-500">Menampilkan {{ $pembudidaya->firstItem() }} - {{ $pembudidaya->lastItem() }} dari {{ $pembudidaya->total() }} Data</p>
        <div>
            {{ $pembudidaya->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<div id="scheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Jadwalkan Verifikasi</h3>
                <p id="modalUserName" class="text-sm text-gray-400 font-medium"></p>
            </div>

            <form action="{{ route('petugas.jadwal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_user" id="modalUserId">

                <div class="px-8 py-6 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Tanggal Verifikasi</label>
                        <input type="date" name="tanggal_verifikasi" required 
                            class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Informasi Lokasi Lapangan:</p>
                        <div class="flex items-start gap-2 text-gray-600">
                            <i class="fa-solid fa-location-dot mt-1 text-green-600 text-xs"></i>
                            <p id="modalLocation" class="text-sm font-bold text-gray-700"></p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 flex gap-4 border-t border-gray-50">
                    <button type="button" onclick="closeScheduleModal()" 
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 px-6 py-3 bg-green-700 text-white rounded-xl text-sm font-bold hover:bg-green-800 transition flex items-center justify-center gap-2 shadow-lg shadow-green-900/20">
                        <i class="fa-regular fa-calendar-check"></i> Buat Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openScheduleModal(id, name, location) {
        document.getElementById('modalUserId').value = id;
        document.getElementById('modalUserName').innerText = name;
        document.getElementById('modalLocation').innerText = location;

        const modal = document.getElementById('scheduleModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeScheduleModal() {
        const modal = document.getElementById('scheduleModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('scheduleModal');
        if (event.target == modal) {
            closeScheduleModal();
        }
    }
</script>
@endsection