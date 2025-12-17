@extends('layouts.pembudidaya')

@section('title', 'Beranda')
@section('subtitle', 'Kelola data usaha budidaya perikanan Anda')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <i class="fa-regular fa-user"></i>
                </div>
                @if($total_permohonan > 0)
                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">Draft</span>
                @endif
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Permohonan Layanan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $total_permohonan ?? 0 }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-1">Pendampingan Selesai</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $pendampingan_selesai ?? '-' }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-1">Status Verifikasi Data</p>
            <h3 class="text-2xl font-bold text-gray-800">
                {{ $status_verifikasi ?? 'Belum Lengkap' }}
            </h3>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-1">Nilai Total Bantuan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp. {{ number_format($total_bantuan ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Lacak Bantuan Terakhir</h3>

        @if(isset($timeline_activities) && count($timeline_activities) > 0)
            
            <div class="relative">
                <div class="absolute left-3 top-2 bottom-4 w-0.5 bg-gray-200"></div>

                <div class="space-y-8">
                    @foreach($timeline_activities as $activity)
                    <div class="relative flex gap-6">
                        <div class="relative z-10 flex-shrink-0 w-6 h-6 rounded-full {{ $activity['status'] == 'done' ? 'bg-green-500' : ($activity['status'] == 'current' ? 'bg-gray-400' : 'bg-gray-300') }} border-4 border-white shadow-sm mt-1"></div>
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="font-bold text-gray-900">{{ $activity['title'] }}</h4>
                                @if($activity['status'] == 'current')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-600 text-xs font-bold rounded">Saat Ini</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 mb-1">{{ $activity['date'] }}</p>
                            <p class="text-sm text-gray-600">{{ $activity['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        @else

            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-box-open text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Belum Ada Aktivitas Bantuan</h4>
                <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">
                    Anda belum mengajukan permohonan bantuan atau layanan apapun. Silakan lengkapi profil usaha Anda dan ajukan layanan baru.
                </p>
                <a href="#" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                    + Ajukan Layanan Baru
                </a>
            </div>

        @endif

    </div>

@endsection