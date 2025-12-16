<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        
        <div class="hidden lg:flex w-1/2 bg-blue-600 flex-col justify-between p-12 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-10 -mt-10"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -ml-10 -mb-10"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('assets/img/logo-dinas.png') }}" alt="Logo" class="h-10 w-10 brightness-200 grayscale">
                    <div>
                        <h1 class="font-bold text-lg">Dinas Perikanan</h1>
                        <p class="text-xs text-blue-200">Sistem Pendataan Digital</p>
                    </div>
                </div>
                
                <h2 class="text-3xl font-bold mb-4 leading-tight">Sistem Pendataan & Verifikasi Pembudidaya Perikanan</h2>
                <p class="text-blue-100 max-w-md">Platform digital terintegrasi untuk memudahkan proses pendaftaran, verifikasi lapangan, dan validasi data pembudidaya perikanan.</p>
            </div>

            <div class="space-y-4 relative z-10">
                <div class="flex items-center gap-4 bg-blue-500/30 p-4 rounded-xl border border-blue-400/30 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white">
                        <i class="fa-solid fa-shield-halved text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Aman & Terpercaya</h4>
                        <p class="text-xs text-blue-100">Sistem terenkripsi dengan audit trail lengkap</p>
                    </div>
                </div>
                 <div class="flex items-center gap-4 bg-blue-500/30 p-4 rounded-xl border border-blue-400/30 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white">
                        <i class="fa-solid fa-file-circle-check text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Verifikasi Otomatis</h4>
                        <p class="text-xs text-blue-100">Workflow bertahap dengan validasi real-time</p>
                    </div>
                </div>
                 <div class="flex items-center gap-4 bg-blue-500/30 p-4 rounded-xl border border-blue-400/30 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Laporan Lengkap</h4>
                        <p class="text-xs text-blue-100">Dashboard analitik dan peta GIS interaktif</p>
                    </div>
                </div>
            </div>

            <div class="text-xs text-blue-200 relative z-10">
                &copy; 2025 Dinas Perikanan. All rights reserved.
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
                
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 mb-6 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Daftar Akun Baru</h2>
                <p class="text-sm text-gray-500 mb-6">Lengkapi data di bawah untuk membuat akun</p>

                <form action="{{ route('register.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Role</label>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="border-2 border-blue-500 bg-blue-50 rounded-lg p-3 text-center cursor-pointer relative">
                                <div class="text-blue-600 mb-1"><i class="fa-solid fa-fish text-lg"></i></div>
                                <span class="text-xs font-bold text-blue-700">Pembudidaya</span>
                                <div class="absolute -top-2 -right-2 bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-3 text-center cursor-not-allowed opacity-50">
                                <div class="text-gray-400 mb-1"><i class="fa-solid fa-clipboard-user text-lg"></i></div>
                                <span class="text-xs font-medium text-gray-500">Petugas UPT</span>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-3 text-center cursor-not-allowed opacity-50">
                                <div class="text-gray-400 mb-1"><i class="fa-solid fa-user-gear text-lg"></i></div>
                                <span class="text-xs font-medium text-gray-500">Administrator</span>
                            </div>
                        </div>
                        <input type="hidden" name="role" value="pembudidaya">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <input type="text" name="nama_lengkap" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input type="email" name="email" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-address-book"></i>
                            </div>
                            <input type="text" name="nomor_hp" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="08123456789" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                        Kirim Kode OTP
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }} " class="text-blue-600 font-semibold hover:underline">Masuk di sini</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>