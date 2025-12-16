<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Dinas Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Hilangkan spinner di input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
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
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-shield-halved text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Aman & Terpercaya</h4><p class="text-xs text-blue-100">Sistem terenkripsi dengan audit trail lengkap</p></div>
                </div>
                <div class="flex items-center gap-4 bg-blue-500/30 p-4 rounded-xl border border-blue-400/30 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-file-circle-check text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Verifikasi Otomatis</h4><p class="text-xs text-blue-100">Workflow bertahap dengan validasi real-time</p></div>
                </div>
                <div class="flex items-center gap-4 bg-blue-500/30 p-4 rounded-xl border border-blue-400/30 backdrop-blur-sm">
                    <div class="bg-white/20 p-2 rounded-lg text-white"><i class="fa-solid fa-chart-line text-xl"></i></div>
                    <div><h4 class="font-bold text-sm">Laporan Lengkap</h4><p class="text-xs text-blue-100">Dashboard analitik dan peta GIS interaktif</p></div>
                </div>
            </div>

            <div class="text-xs text-blue-200 relative z-10">&copy; 2025 Dinas Perikanan. All rights reserved.</div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
                
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 mb-6 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">Masukan Kode OTP</h2>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                    Silahkan periksa kontak masuk email Anda untuk melihat kode OTP, Masukan Kode OTP sekali pakai dibawah ini.
                </p>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-100 text-center">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg mb-4 border border-green-100 text-center">
                        {{ session('success') }}
                    </div>
                @endif


                @if(isset($is_reset) && $is_reset)
                    <form action="{{ route('password.otp.process') }}" method="POST" id="otpForm">
                    @csrf
                    
                    <input type="hidden" name="id_user" value="{{ request()->id ?? $user->id_user }}">
                    
                    <input type="hidden" name="otp_code" id="otp_code_combined">

                    <div class="flex justify-between gap-4 mb-8">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50" autofocus>
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                    </div>

                    <div class="text-center text-sm text-gray-500 mb-8">
                        Anda dapat mengirim ulang kode dalam <span id="timer" class="font-bold text-gray-900">59</span> detik<br>
                        <a href="#" id="resendLink" class="text-blue-600 font-bold hover:underline hidden mt-2 block">Kirim ulang kode</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                        Lanjutkan
                    </button>
                </form>
                @else
                <form action="{{ route('otp.process') }}" method="POST" id="otpForm">
                    @csrf
                    
                    <input type="hidden" name="id_user" value="{{ request()->id ?? $user->id_user }}">
                    
                    <input type="hidden" name="otp_code" id="otp_code_combined">

                    <div class="flex justify-between gap-4 mb-8">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50" autofocus>
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                        <input type="text" maxlength="1" class="otp-input w-20 h-20 border border-gray-300 rounded-xl text-center text-3xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                    </div>

                    <div class="text-center text-sm text-gray-500 mb-8">
                        Anda dapat mengirim ulang kode dalam <span id="timer" class="font-bold text-gray-900">59</span> detik<br>
                        <a href="#" id="resendLink" class="text-blue-600 font-bold hover:underline hidden mt-2 block">Kirim ulang kode</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                        Lanjutkan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // 1. Logika Pindah Kotak Input Otomatis
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otp_code_combined');

        inputs.forEach((input, index) => {
            // Hanya izinkan angka
            input.addEventListener('input', (e) => {
                // Hapus karakter non-angka
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                if (e.target.value.length === 1) {
                    // Pindah ke kotak berikutnya jika ada
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
                updateHiddenInput();
            });

            // Handle Backspace (Pindah mundur)
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value) {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
        });

        function updateHiddenInput() {
            let code = '';
            inputs.forEach(input => code += input.value);
            hiddenInput.value = code;
        }

        // 2. Logika Timer Mundur
        let timeLeft = 59;
        const timerElement = document.getElementById('timer');
        const resendLink = document.getElementById('resendLink');

        const countdown = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerElement.parentElement.innerHTML = "Belum menerima kode?"; // Ganti teks
                resendLink.classList.remove('hidden'); // Munculkan link kirim ulang
            } else {
                timerElement.innerText = timeLeft;
                timeLeft--;
            }
        }, 1000);
    </script>

</body>
</html>