<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Perikanan - Sistem Pendataan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6', // Biru tombol
                        secondary: '#10B981', // Hijau verifikasi
                        dark: '#1F2937', // Warna text gelap
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white fixed w-full z-50 shadow-sm top-0 left-0">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo-dinas.png') }}" alt="Logo" class="h-10 w-10"> <div class="leading-tight">
                    <h1 class="font-bold text-gray-900 text-lg">Dinas Perikanan</h1>
                    <p class="text-xs text-blue-600 font-medium">Sistem Pendataan Digital</p>
                </div>
            </div>

            <div class="hidden md:flex gap-8 text-sm font-medium text-gray-600">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                <a href="#alur" class="hover:text-blue-600 transition">Alur Kerja</a>
                <a href="#tentang" class="hover:text-blue-600 transition">Tentang</a>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                    Daftar Sekarang <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-10 mb-10">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('assets/img/logo-dinas.png') }}" class="h-10 w-10 grayscale brightness-200"> 
                        <div class="leading-tight">
                            <h2 class="font-bold text-white text-lg">Dinas Perikanan</h2>
                            <p class="text-xs text-gray-400">Sistem Pendataan Digital</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Platform digital untuk pendataan dan verifikasi pembudidaya perikanan yang modern, efisien, dan transparan.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Menu Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-blue-400 transition">Fitur</a></li>
                        <li><a href="#alur" class="hover:text-blue-400 transition">Alur Kerja</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-3 text-sm">
                        <li><i class="fa-solid fa-phone mr-2 text-blue-500"></i> (0281) 636149</li>
                        <li><i class="fa-solid fa-location-dot mr-2 text-blue-500"></i> Purwokerto Timur, 53114</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex justify-between text-xs text-gray-500">
                <p>&copy; 2025 Dinas Perikanan. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>