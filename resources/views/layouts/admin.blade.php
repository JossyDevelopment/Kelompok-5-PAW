<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex">

    <aside class="w-64 bg-white h-screen sticky top-0 border-r border-gray-100 flex flex-col justify-between py-6">
        <div>
            <div class="px-6 mb-8 flex items-center gap-3">
               <img src="{{ asset('assets/img/logo-dinas.png') }}" class="h-8 w-8 mr-3">
                <div>
                    <h2 class="text-sm font-bold text-gray-800">Dinas Perikanan</h2>
                    <p class="text-[10px] text-purple-600 font-bold uppercase tracking-wider">Admin</p>
                </div>
            </div>

            <nav class="space-y-1 px-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('admin.master.komoditas') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all
                {{ request()->routeIs('admin.master.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-gears"></i> Kelola Master Data
                </a>
                <a href="{{ route('admin.permohonan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all
                {{ request()->routeIs('admin.permohonan.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-file-invoice"></i> Permohonan
                </a>
                <a href="{{ route('admin.pendampingan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all
                {{ request()->routeIs('admin.pendampingan.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-compass"></i> Pendampingan
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all
                {{ request()->routeIs('admin.laporan.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'text-gray-500 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-book"></i> Laporan
                </a>
            </nav>
        </div>

        <div class="px-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 w-full transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-h-screen">
        @yield('content')
    </main>

</body>
</html>