{{-- Sisi Pembudidaya: Konfirmasi Penerimaan --}}
@extends('layouts.pembudidaya')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="font-bold text-gray-800 text-sm mb-4 uppercase tracking-wide">Status Bantuan Penerimaan</h3>

    <div class="space-y-4">
        @foreach($daftar_bantuan as $item)
            @if($item->status == 'dikirim')
                <div id="card-{{ $item->no_tiket }}" class="border border-blue-200 bg-blue-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
                    <div class="flex items-start gap-3 w-full">
                        <div id="icon-{{ $item->no_tiket }}" class="text-blue-600 mt-1">
                            <i class="fa-solid fa-truck-fast text-lg animate-pulse"></i>
                        </div>
                        <div>
                            <h4 id="title-{{ $item->no_tiket }}" class="text-blue-700 font-bold text-sm">
                                {{ $item->no_tiket }}: {{ $item->detail_kebutuhan }}
                            </h4>
                            <span class="inline-block px-2 py-0.5 bg-blue-600 text-white text-[10px] font-bold rounded uppercase mb-1">Dalam Pengiriman</span>
                            <p class="text-xs text-gray-600">
                                Estimasi tiba/dikirim sejak: {{ \Carbon\Carbon::parse($item->tanggal_diterima)->format('d M Y') }}.
                            </p>
                        </div>
                    </div>

                    
                </div>
            
            {{-- Jika status sudah 'selesai' --}}
            @elseif($item->status == 'selesai')
                <div class="border border-green-200 bg-green-50/50 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4 opacity-75">
                    <div class="flex items-start gap-3 w-full">
                        <div class="text-green-600 mt-1">
                            <i class="fa-regular fa-circle-check text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-green-700 font-bold text-sm">{{ $item->no_tiket }}: {{ $item->detail_kebutuhan }}</h4>
                            <p class="text-xs text-gray-600 mt-1">
                                Telah diterima pada {{ \Carbon\Carbon::parse($item->tanggal_diterima)->format('d M Y') }}.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        @endforeach
    </div>
</div>

@endsection