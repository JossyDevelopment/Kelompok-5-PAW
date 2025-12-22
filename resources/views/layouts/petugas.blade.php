<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full z-10">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-dinas.png') }}" class="h-8 w-8 mr-3">
                <div>
                    <h1 class="font-bold text-gray-800 text-sm leading-tight">Dinas Perikanan</h1>
                    <p class="text-[10px] text-green-600 font-bold">Petugas UPT</p>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-4 space-y-6">
            
            <div>
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Verifikasi Pembudidaya</p>
                <nav class="space-y-1">
                    <a href="{{ route('petugas.verifikasi') }}" 
                       class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                       {{ request()->routeIs('petugas.verifikasi') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-user-check w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Verifikasi Budidaya</span>
                    </a>
                </nav>
            </div>

            <div>
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Proses Bantuan</p>
                <nav class="space-y-1">
                    <a href="{{ route('petugas.bantuan.index') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                    {{ request()->routeIs('petugas.bantuan.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-file-circle-check w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Verifikasi Bantuan</span>
                    </a>
                    <a href="{{ route('petugas.penyaluran.index') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                    {{ request()->routeIs('petugas.penyaluran.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-truck-fast w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Penyaluran</span>
                    </a>
                     <a href="{{ route('petugas.monitoring.index') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                    {{ request()->routeIs('petugas.monitoring.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-chart-line w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Monitoring</span>
                    </a>
                </nav>
            </div>
 
             <div>
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pendampingan</p>
                <nav class="space-y-1">
                   <a href="{{ route('petugas.pendampingan.index') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                    {{ request()->routeIs('petugas.pendampingan.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-clipboard-list w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Daftar Permohonan</span>
                    </a>
                    <a href="{{ route('petugas.pendampingan.input') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mx-2
                    {{ request()->routeIs('petugas.pendampingan.input') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-regular fa-pen-to-square w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Input Hasil</span>
                    </a>
                </nav>
            </div>
        </div>

        

        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-6 text-center text-sm"></i>
                    <span class="text-sm font-medium ml-2">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="ml-64 flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">
            <div>
                <h2 class="text-lg font-bold text-gray-800">@yield('title')</h2>
                <p class="text-xs text-gray-500">@yield('subtitle')</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-gray-400 hover:text-gray-600 relative">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <div class="flex items-center gap-2 border-l border-gray-200 pl-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gray-700">{{ Auth::user()->nama_lengkap ?? 'Petugas' }}</p>
                        <p class="text-xs text-green-600">Petugas UPT</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold border border-green-200">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>