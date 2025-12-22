@extends('layouts.petugas')

@section('title', 'Monitoring Pemanfaatan')
@section('subtitle', 'Monitoring Pemanfaatan Bantuan')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Jadwal & Laporan Monitoring</h3>
            <p class="text-xs text-gray-400 mt-1">Daftar bantuan berstatus 'Selesai' yang perlu dipantau pemanfaatannya di lapangan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b">
                        <th class="p-6">Penerima</th>
                        <th class="p-6">Jenis Bantuan</th>
                        <th class="p-6">Monitoring Terakhir</th>
                        <th class="p-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($monitoring as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-6">
                            <p class="text-sm text-gray-700 font-bold">{{ $item->nama_penerima }}</p>
                            <p class="text-[10px] text-gray-400">ID Permohonan: #{{ $item->id }}</p>
                        </td>
                        <td class="p-6 text-sm text-gray-500">
                            <span class="font-medium text-gray-700">{{ ucfirst($item->jenis_bantuan) }}</span>
                            <p class="text-xs italic">{{ $item->detail_kebutuhan }}</p>
                        </td>
                        <td class="p-6 text-sm text-gray-500">
                            @if(!$item->tanggal_monitoring_terakhir)
                                <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded border border-amber-100">BELUM DIMONITORING</span>
                            @else
                                <div class="flex items-center gap-2 text-green-700">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <span class="font-bold">{{ \Carbon\Carbon::parse($item->tanggal_monitoring_terakhir)->format('d M Y') }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-6">
                            <button 
                                onclick="openMonitoringModal('{{ $item->id }}', '{{ $item->nama_penerima }}')"
                                class="text-sm font-bold {{ $item->tanggal_monitoring_terakhir ? 'text-blue-600 hover:text-blue-800' : 'text-green-600 hover:text-green-800' }} transition flex items-center gap-1">
                                <i class="fa-solid fa-calendar-day"></i>
                                {{ $item->tanggal_monitoring_terakhir ? 'Jadwal Ulang' : 'Jadwalkan' }}
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-gray-400 font-medium">
                            <i class="fa-solid fa-clipboard-list text-4xl mb-3 block opacity-20"></i>
                            Belum ada bantuan yang siap dimonitoring (Status bantuan harus 'Selesai').
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-white border-t border-gray-100">
            {{ $monitoring->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<div id="monitoringModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Jadwalkan Monitoring</h3>
                <p id="modalPenerimaName" class="text-sm text-gray-400 font-medium mt-1"></p>
            </div>

            <form action="{{ route('petugas.monitoring.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="modalPermohonanId">

                <div class="px-8 py-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Tanggal Monitoring:</label>
                    <input type="date" name="tanggal_monitoring" required 
                        class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500 outline-none transition">
                    <p class="text-[10px] text-gray-400 mt-2 italic">*Monitoring dilakukan untuk mengecek pemanfaatan bantuan oleh pembudidaya.</p>
                </div>

                <div class="px-8 py-6 bg-gray-50 flex gap-4 border-t border-gray-100">
                    <button type="button" onclick="closeMonitoringModal()" 
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-600 hover:bg-white transition">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 px-6 py-3 bg-green-700 text-white rounded-xl text-sm font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openMonitoringModal(id, name) {
        document.getElementById('modalPermohonanId').value = id;
        document.getElementById('modalPenerimaName').innerText = "Penerima: " + name;

        const modal = document.getElementById('monitoringModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMonitoringModal() {
        const modal = document.getElementById('monitoringModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Tutup modal jika klik di luar area modal
    window.onclick = function(event) {
        const modal = document.getElementById('monitoringModal');
        if (event.target == modal) {
            closeMonitoringModal();
        }
    }
</script>
@endsection