@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Pendampingan</h1>
        <p class="text-sm text-gray-400 font-medium tracking-tight">Monitoring Pendampingan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Permohonan</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Selesai</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['selesai'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Sedang Berjalan</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['berjalan'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between h-40">
            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Menunggu Jadwal</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $stats['menunggu'] }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm flex gap-4">
        <a href="{{ route('admin.pendampingan.index', ['tab' => 'monitoring']) }}" 
           class="px-8 py-3 rounded-2xl text-sm font-bold transition {{ $tab == 'monitoring' ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
            Monitoring Pelaksana
        </a>
        <a href="{{ route('admin.pendampingan.index', ['tab' => 'rekap']) }}" 
           class="px-8 py-3 rounded-2xl text-sm font-bold transition {{ $tab == 'rekap' ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
            Rekap Permohonan
        </a>
    </div>

    @if($tab == 'rekap')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
                <h3 class="text-lg font-bold text-gray-800">Permintaan Berdasarkan Topik</h3>
                <div class="space-y-6">
                    @foreach($topikStats as $t)
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold text-gray-700">
                            <span>{{ $t->nama_topik }}</span>
                            <span class="text-gray-400">{{ $t->total }} ({{ $stats['total'] > 0 ? round(($t->total / $stats['total']) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($t->total / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-[40px] border border-gray-100 p-10 shadow-sm space-y-8">
                <h3 class="text-lg font-bold text-gray-800">Permintaan Berdasarkan Wilayah</h3>
                <div class="space-y-6">
                    @foreach($wilayahStats as $w)
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold text-gray-700">
                            <span>{{ $w->wilayah ?? 'Tidak Diketahui' }}</span>
                            <span class="text-gray-400">{{ $w->total }} ({{ $stats['total'] > 0 ? round(($w->total / $stats['total']) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($w->total / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden mt-6">
            <div class="p-8 border-b border-gray-50">
                <h3 class="text-lg font-bold text-gray-800">2 Persetujuan/Penolakan Terakhir</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="px-8 py-6">NO</th>
                            <th class="px-8 py-6">PETUGAS UPT</th>
                            <th class="px-8 py-6">PEMBUDIDAYA</th>
                            <th class="px-8 py-6">TOPIK PENDAMPINGAN</th>
                            <th class="px-8 py-6">JADWAL/SELESAI</th>
                            <th class="px-8 py-6 text-center">STATUS</th>
                            <th class="px-8 py-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pendampingan as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $pendampingan->firstItem() + $index }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-800">{{ $item->nama_petugas }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-800">{{ $item->nama_pembudidaya }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600">{{ $item->nama_topik }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-500">{{ $item->tanggal_pelaksanaan ? date('d/m/Y', strtotime($item->tanggal_pelaksanaan)) : '-' }}</td>
                            <td class="px-8 py-6 text-center">
                                @if($item->status == 'dijadwalkan')
                                    <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-[10px] font-black rounded-lg border border-amber-100 uppercase">Dijadwalkan</span>
                                @elseif($item->status == 'selesai')
                                    <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100 uppercase">Selesai</span>
                                @elseif($item->status == 'sedang_berjalan')
                                    <span class="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100 uppercase">Sedang Berjalan</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <a href="#" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition border border-blue-100 mx-auto">
                                    <i class="fa-solid fa-file-lines text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection