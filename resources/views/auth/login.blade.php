<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .transition-theme { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        
        <div id="left-sidebar" class="hidden lg:flex w-1/2 bg-blue-600 flex-col justify-between p-12 text-white relative overflow-hidden transition-theme">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl opacity-50 -mr-10 -mt-10"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl opacity-50 -ml-10 -mb-10"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('assets/img/logo-dinas.png') }}" alt="Logo" class="h-10 w-10 brightness-200 grayscale">
                    <div>
                        <h1 class="font-bold text-lg">Dinas Perikanan</h1>
                        <p class="text-xs text-white/80">Sistem Pendataan Digital</p>
                    </div>
                </div>
                
                <h2 class="text-3xl font-bold mb-4 leading-tight">Sistem Pendataan & Verifikasi Pembudidaya Perikanan</h2>
                <p class="text-white/80 max-w-md">Platform digital terintegrasi untuk memudahkan proses pendaftaran, verifikasi lapangan, dan validasi data pembudidaya perikanan.</p>
            </div>

            <div class="space-y-4 relative z-10">
                <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/20 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-shield-halved text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Aman & Terpercaya</h4><p class="text-xs text-white/70">Sistem terenkripsi dengan audit trail lengkap</p></div>
                </div>
                <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/20 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-file-circle-check text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Verifikasi Otomatis</h4><p class="text-xs text-white/70">Workflow bertahap dengan validasi real-time</p></div>
                </div>
                <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/20 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-chart-line text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Laporan Lengkap</h4><p class="text-xs text-white/70">Dashboard analitik dan peta GIS interaktif</p></div>
                </div>
            </div>

            <div class="text-xs text-white/60 relative z-10">&copy; 2025 Dinas Perikanan. All rights reserved.</div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 transition-theme">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
                
                <a href="{{ url('/') }}" id="back-link" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 mb-6 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Masuk ke Sistem</h2>
                <p class="text-sm text-gray-500 mb-6">Masukkan kredensial Anda untuk melanjutkan</p>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-100">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg mb-4 border border-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Role</label>
                        <div class="grid grid-cols-3 gap-3">
                            
                            <div onclick="selectRole('pembudidaya')" id="card-pembudidaya" class="role-card border-2 border-blue-500 bg-blue-50 rounded-lg p-3 text-center cursor-pointer relative transition-all">
                                <div class="icon-color text-blue-600 mb-1"><i class="fa-solid fa-fish text-lg"></i></div>
                                <span class="text-color text-xs font-bold text-blue-700">Pembudidaya</span>
                                <div id="check-pembudidaya" class="check-icon absolute -top-2 -right-2 bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                            
                            <div onclick="selectRole('petugas')" id="card-petugas" class="role-card border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:bg-gray-50 transition-all opacity-60">
                                <div class="icon-color text-gray-400 mb-1"><i class="fa-solid fa-clipboard-user text-lg"></i></div>
                                <span class="text-color text-xs font-medium text-gray-500">Petugas UPT</span>
                                <div id="check-petugas" class="check-icon hidden absolute -top-2 -right-2 bg-green-600 text-white rounded-full w-5 h-5 items-center justify-center text-xs">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>

                            <div onclick="selectRole('admin')" id="card-admin" class="role-card border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:bg-gray-50 transition-all opacity-60">
                                <div class="icon-color text-gray-400 mb-1"><i class="fa-solid fa-user-gear text-lg"></i></div>
                                <span class="text-color text-xs font-medium text-gray-500">Administrator</span>
                                <div id="check-admin" class="check-icon hidden absolute -top-2 -right-2 bg-purple-600 text-white rounded-full w-5 h-5 items-center justify-center text-xs">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input type="text" name="username" id="input-username" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm transition-theme" placeholder="nama@email.com" required value="{{ old('username') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" id="input-password" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm transition-theme" placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <div id="extra-options" class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="remember" class="ml-2 text-sm text-gray-500">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" id="link-forgot" class="text-sm text-blue-600 hover:underline font-medium transition-theme">Lupa password?</a>
                    </div>

                    <button type="submit" id="btn-submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 transition-theme">
                        Masuk
                    </button>
                </form>

                <div id="footer-register" class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun? <a href="{{ route('register') }}" id="link-register" class="text-blue-600 font-semibold hover:underline transition-theme">Daftar sekarang</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        function selectRole(role) {
            // 1. Definisi Tema Warna
            const themes = {
                'pembudidaya': {
                    color: 'blue',
                    bgLeft: 'bg-blue-600',
                    border: 'border-blue-500',
                    bgLight: 'bg-blue-50',
                    text: 'text-blue-700',
                    icon: 'text-blue-600',
                    btn: 'bg-blue-600',
                    btnHover: 'hover:bg-blue-700',
                    shadow: 'shadow-blue-600/30',
                    ring: 'focus:ring-blue-500',
                    borderInput: 'focus:border-blue-500'
                },
                'petugas': {
                    color: 'green',
                    bgLeft: 'bg-green-600',
                    border: 'border-green-600',
                    bgLight: 'bg-green-50',
                    text: 'text-green-800',
                    icon: 'text-green-700',
                    btn: 'bg-green-700',
                    btnHover: 'hover:bg-green-800',
                    shadow: 'shadow-green-600/30',
                    ring: 'focus:ring-green-600',
                    borderInput: 'focus:border-green-600'
                },
                'admin': {
                    color: 'purple',
                    bgLeft: 'bg-purple-900',
                    border: 'border-purple-600',
                    bgLight: 'bg-purple-50',
                    text: 'text-purple-800',
                    icon: 'text-purple-700',
                    btn: 'bg-purple-800',
                    btnHover: 'hover:bg-purple-900',
                    shadow: 'shadow-purple-600/30',
                    ring: 'focus:ring-purple-600',
                    borderInput: 'focus:border-purple-600'
                }
            };

            const selectedTheme = themes[role];

            // 2. Ubah Background Kiri
            const leftSidebar = document.getElementById('left-sidebar');
            // Hapus class warna lama
            leftSidebar.classList.remove('bg-blue-600', 'bg-green-600', 'bg-purple-900');
            // Tambah class warna baru
            leftSidebar.classList.add(selectedTheme.bgLeft);

            // 3. Reset Semua Kartu Role
            const cards = ['pembudidaya', 'petugas', 'admin'];
            cards.forEach(c => {
                const card = document.getElementById(`card-${c}`);
                const check = document.getElementById(`check-${c}`);
                const icon = card.querySelector('.icon-color');
                const text = card.querySelector('.text-color');

                // Reset style ke 'inactive'
                card.className = "role-card border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:bg-gray-50 transition-all opacity-60";
                check.classList.add('hidden'); // Sembunyikan centang
                check.classList.remove('flex');
                
                // Reset text/icon color ke gray
                icon.className = "icon-color text-gray-400 mb-1";
                text.className = "text-color text-xs font-medium text-gray-500";
            });

            // 4. Set Style Kartu Aktif
            const activeCard = document.getElementById(`card-${role}`);
            const activeCheck = document.getElementById(`check-${role}`);
            const activeIcon = activeCard.querySelector('.icon-color');
            const activeText = activeCard.querySelector('.text-color');

            // Hapus opacity, tambah border & bg warna
            activeCard.className = `role-card border-2 ${selectedTheme.border} ${selectedTheme.bgLight} rounded-lg p-3 text-center cursor-pointer relative transition-all`;
            
            // Tampilkan centang
            activeCheck.classList.remove('hidden');
            activeCheck.classList.add('flex');

            // Warnai text & icon
            activeIcon.className = `icon-color ${selectedTheme.icon} mb-1`;
            activeText.className = `text-color text-xs font-bold ${selectedTheme.text}`;

            // 5. Ubah Warna Input (Focus Ring)
            const inputs = ['input-username', 'input-password'];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                // Regex replace ring-* dan border-*
                el.className = el.className.replace(/focus:ring-\w+-\d+/g, selectedTheme.ring);
                el.className = el.className.replace(/focus:border-\w+-\d+/g, selectedTheme.borderInput);
            });

            // 6. Ubah Tombol Submit
            const btn = document.getElementById('btn-submit');
            // Reset class tombol
            btn.className = `w-full text-white font-bold py-3 rounded-lg transition-theme transition shadow-lg ${selectedTheme.btn} ${selectedTheme.btnHover} ${selectedTheme.shadow}`;

            // 7. Ubah Warna Link (Back & Forgot)
            const backLink = document.getElementById('back-link');
            const forgotLink = document.getElementById('link-forgot');
            
            // Hapus class hover lama text-*-600
            backLink.className = backLink.className.replace(/hover:text-\w+-\d+/g, `hover:${selectedTheme.icon}`);
            forgotLink.className = forgotLink.className.replace(/text-\w+-\d+/g, selectedTheme.icon);

            // 8. Tampilkan/Sembunyikan Footer Register
            const extraOptions = document.getElementById('extra-options')
            const footer = document.getElementById('footer-register');
            const linkReg = document.getElementById('link-register');
            
            if (role === 'pembudidaya') {
                extraOptions.style.display = 'flex'
                footer.style.display = 'block';
                linkReg.className = linkReg.className.replace(/text-\w+-\d+/g, selectedTheme.icon);
            } else {
                extraOptions.style.display = 'none'
                footer.style.display = 'none';
            }
        }
    </script>

</body>
</html>