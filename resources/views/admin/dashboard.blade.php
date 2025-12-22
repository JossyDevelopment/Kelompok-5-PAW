@extends('layouts.admin')

@section('content')
<div class="p-8 space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-sm text-gray-400">Sistem manajemen data pembudidaya perikanan</p>
        </div>
        <div class="flex items-center gap-6">
            <button class="relative text-gray-400">
                <i class="fa-solid fa-bell text-xl"></i>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="flex items-center gap-3 border-l pl-6 border-gray-100">
                <div class="text-right">
                    <p class="text-xs text-gray-400">User</p>
                    <p class="text-sm font-bold text-gray-800">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-purple-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg shadow-purple-100">A</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-users"></i></div>
            <h3 class="text-2xl font-black text-gray-800">{{ number_format($stats['total_pembudidaya']) }}</h3>
            <p class="text-xs text-gray-400 font-medium">Total Pembudidaya</p>
            <p class="text-[10px] text-green-500 mt-2 font-bold">↑ 12% dari bulan lalu</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-circle-check"></i></div>
            <h3 class="text-2xl font-black text-gray-800">{{ number_format($stats['bantuan_disalurkan']) }}</h3>
            <p class="text-xs text-gray-400 font-medium">Bantuan Disalurkan</p>
            <p class="text-[10px] text-green-600 mt-2 font-bold">76% completion rate</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h3 class="text-2xl font-black text-gray-800">{{ $stats['permohonan_pending'] }}</h3>
            <p class="text-xs text-gray-400 font-medium">Permohonan Pending</p>
            <p class="text-[10px] text-orange-500 mt-2 font-bold">Segera tindak lanjuti</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <h3 class="text-2xl font-black text-gray-800">{{ $stats['pendampingan_ini'] }}</h3>
            <p class="text-xs text-gray-400 font-medium">Pendampingan Bulan Ini</p>
            <p class="text-[10px] text-gray-400 mt-2 font-medium">5 Komoditas utama</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6">Trend Pendaftaran Pembudidaya</h3>
            <canvas id="trendChart" height="200"></canvas>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6">Distribusi Komoditas</h3>
            <canvas id="commodityChart" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-6">Sebaran Pembudidaya per Wilayah</h3>
        <canvas id="regionChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Line Chart: Trend (Biru)
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: [40, 55, 60, 58, 65, 75],
                borderColor: '#2563eb',
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#2563eb'
            }]
        }
    });

    // 2. Donut Chart: Komoditas
    new Chart(document.getElementById('commodityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Lele', 'Nila', 'Udang', 'Gurame', 'Bandeng'],
            datasets: [{
                data: [320, 245, 189, 156, 124],
                backgroundColor: ['#1d4ed8', '#15803d', '#f97316', '#a855f7', '#fbbf24']
            }]
        },
        options: { cutout: '70%', plugins: { legend: { position: 'right' } } }
    });

    // 3. Bar Chart: Wilayah (image_65b1e8.png)
    new Chart(document.getElementById('regionChart'), {
        type: 'bar',
        data: {
            labels: ['Cibinong', 'Bojonggede', 'Ciseeng', 'Gunung Putri', 'Citeureup'],
            datasets: [
                { label: 'Total', data: [340, 310, 310, 180, 150], backgroundColor: '#1d4ed8', borderRadius: 5 },
                { label: 'Terverifikasi', data: [290, 260, 210, 140, 110], backgroundColor: '#15803d', borderRadius: 5 }
            ]
        }
    });
</script>
@endsection