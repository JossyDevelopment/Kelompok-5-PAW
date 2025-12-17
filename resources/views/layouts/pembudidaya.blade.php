<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembudidaya - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col justify-between">
            <div>
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <img src="{{ asset('assets/img/logo-dinas.png') }}" class="h-8 w-8 mr-3">
                    <div>
                        <h1 class="font-bold text-gray-800 text-sm leading-tight">Dinas Perikanan</h1>
                        <p class="text-xs text-blue-600 font-medium">Pembudidaya</p>
                    </div>
                </div>

                <div class="p-4 space-y-8 overflow-y-auto" style="height: calc(100vh - 120px);">
                    
                    <div>
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Data Saya</p>
                        <nav class="space-y-1">
                            
                            <a href="{{ route('pembudidaya.dashboard') }}" 
                            class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-solid fa-house w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Beranda</span>
                            </a>

                            <a href="{{ route('pembudidaya.profil') }}" 
                            class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.profil') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-regular fa-user w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Profil & Usaha</span>
                            </a>

                        </nav>
                    </div>

                    <div>
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Bantuan & Realisasi</p>
                        <nav class="space-y-1">
                            <a href="{{ route('pembudidaya.ajukan') }}" class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.ajukan') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-solid fa-circle-plus w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Ajukan Layanan</span>
                            </a>
                            <a href="{{ route('pembudidaya.status') }}" 
                                class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.status') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-regular fa-clock w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Status & Lacak</span>
                            </a>
                             <a href="{{ route('pembudidaya.penerimaan') }}" 
                                class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.penerimaan') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-solid fa-hand-holding-hand w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Penerimaan</span>
                            </a>
                        </nav>
                    </div>

                    <div>
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pendampingan Teknis</p>
                        <nav class="space-y-1">
                            <a href="{{ route('pembudidaya.pendampingan.ajukan') }}" 
                            class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.pendampingan.ajukan') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-solid fa-life-ring w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Ajukan</span>
                            </a>
                            <a href="{{ route('pembudidaya.pendampingan.jadwal') }}" 
                            class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('pembudidaya.pendampingan.jadwal') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="fa-regular fa-calendar-check w-6 text-center text-sm"></i>
                                <span class="text-sm font-medium ml-2">Jadwal & Feedback</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket w-6 text-center text-sm"></i>
                        <span class="text-sm font-medium ml-2">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-full overflow-hidden">
            
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Beranda')</h2>
                    <p class="text-xs text-gray-500">@yield('subtitle', 'Kelola data usaha budidaya perikanan Anda')</p>
                </div>

                <div class="flex items-center gap-6">
                    <button class="relative text-gray-400 hover:text-gray-600">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->nama_lengkap ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">Pembudidaya</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                            {{ substr(Auth::user()->nama_lengkap ?? 'U', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50 p-8">
                @yield('content')
            </main>

        </div>
    </div>

    <div id="success-notification" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/20 backdrop-blur-[2px] transition-opacity duration-300 opacity-0">
        
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-sm text-center transform scale-90 transition-transform duration-300" id="success-card">
            
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-600/30">
                <i class="fa-solid fa-check text-4xl text-white"></i>
            </div>

            <h3 id="success-message" class="text-xl font-bold text-gray-800 mb-2">Data Berhasil Disimpan</h3>
            
            </div>
    </div>

    <script>
        /**
         * Fungsi untuk memunculkan notifikasi sukses
         * @param {string} message - Pesan yang ingin ditampilkan (Opsional)
         */
        function showSuccess(message = "Data Berhasil Disimpan") {
            const modal = document.getElementById('success-notification');
            const card = document.getElementById('success-card');
            const msgElement = document.getElementById('success-message');

            // 1. Set Pesan
            msgElement.innerText = message;

            // 2. Tampilkan Modal (Hapus hidden)
            modal.classList.remove('hidden');

            // 3. Animasi Masuk (Fade In + Zoom In)
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-90');
                card.classList.add('scale-100');
            }, 10);

            // 4. Auto Close setelah 2 Detik
            setTimeout(() => {
                closeSuccess();
            }, 2000); 
        }

        function closeSuccess() {
            const modal = document.getElementById('success-notification');
            const card = document.getElementById('success-card');

            // Animasi Keluar
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-90');

            // Sembunyikan elemen setelah animasi selesai
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccess("{{ session('success') }}");
            });
        </script>
    @endif
</body>
</html>