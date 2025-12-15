@extends('layouts.landing')

@section('content')

<section class="relative bg-white overflow-hidden py-16 lg:py-24">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-semibold mb-6">
                    <i class="fa-solid fa-shield-halved"></i> Sistem Terverifikasi & Terpercaya
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    Sistem Pendataan & <br> Verifikasi <span class="text-blue-600">Pembudidaya</span>
                </h1>
                <p class="text-gray-500 text-lg mb-8 leading-relaxed">
                    Platform digital terpadu untuk mempercepat pendaftaran, verifikasi lapangan, serta validasi data pembudidaya secara transparan, akurat, dan akuntabel.
                </p>
                <div class="flex gap-4 mb-12">
                    <a href="#" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition">
                        Mulai Pendaftaran <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition flex items-center gap-2">
                        <i class="fa-regular fa-circle-play"></i> Lihat Demo
                    </a>
                </div>
                
                <div class="flex gap-12 border-t pt-8">
                    <div>
                        <h4 class="text-2xl font-bold text-blue-600">2.456</h4>
                        <p class="text-sm text-gray-500">Pembudidaya</p>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-green-600">1.872</h4>
                        <p class="text-sm text-gray-500">Terverifikasi</p>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-blue-600">15</h4>
                        <p class="text-sm text-gray-500">Kecamatan</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <img src="{{ asset('assets/img/hero-kolam.jpg') }}" alt="Tambak Ikan" class="rounded-3xl shadow-2xl w-full object-cover h-[500px]">
                
                <div class="absolute top-10 -right-4 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                    <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
                        <i class="fa-solid fa-shield-cat"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Aman & Terpercaya</p>
                        <p class="font-bold text-sm">Audit Trail</p>
                    </div>
                </div>

                <div class="absolute -bottom-6 left-10 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4">
                    <div class="bg-green-100 p-3 rounded-lg text-green-600">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Status Waktu Nyata</p>
                        <p class="text-xs text-green-600">Melacak Otomatis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fitur" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="bg-blue-100 text-blue-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Fitur Unggulan</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-4 mb-4">Solusi Digital Terintegrasi</h2>
            <p class="text-gray-500">Sistem dengan workflow jelas untuk pendataan, verifikasi, pendampingan, dan pelaporan perikanan.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                    <i class="fa-solid fa-fish"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Pembudidaya</h3>
                <p class="text-sm text-gray-500 mb-6">Kelola usaha dan ajukan layanan secara mandiri.</p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Pendaftaran & Input Data
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Pengajuan Bantuan
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Tracking Status
                    </li>
                </ul>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                    <i class="fa-solid fa-clipboard-user"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Petugas UPT</h3>
                <p class="text-sm text-gray-500 mb-6">Verifikasi, survei, dan pendampingan lebih terstruktur.</p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Verifikasi Lapangan
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Validasi Permohonan
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Upload Absensi
                    </li>
                </ul>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Admin</h3>
                <p class="text-sm text-gray-500 mb-6">Kontrol penuh terhadap data, monitoring dan pelaporan.</p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Kelola Data Master
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Monitoring Kinerja
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i> Laporan & Evaluasi
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="alur" class="py-20 bg-blue-50/50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Alur Kerja Sistem</span>
            <h2 class="text-2xl font-bold mt-4">Workflow yang Jelas & Terstruktur</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative mb-12">
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10 -translate-y-1/2"></div>

            <div class="bg-white p-6 rounded-xl shadow-md text-center border border-gray-200 relative">
                <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center font-bold mx-auto mb-4">1</div>
                <h4 class="font-bold">Draft</h4>
                <p class="text-xs text-gray-500 mt-2">Pengisian data awal pembudidaya</p>
            </div>
             <div class="bg-white p-6 rounded-xl shadow-md text-center border border-gray-200 relative">
                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold mx-auto mb-4">2</div>
                <h4 class="font-bold">Diajukan</h4>
                <p class="text-xs text-gray-500 mt-2">Menunggu Verifikasi Petugas UPT</p>
            </div>
             <div class="bg-white p-6 rounded-xl shadow-md text-center border border-gray-200 relative">
                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mx-auto mb-4">3</div>
                <h4 class="font-bold">Verifikasi</h4>
                <p class="text-xs text-gray-500 mt-2">Administrasi & Survei Lapangan</p>
            </div>
             <div class="bg-white p-6 rounded-xl shadow-md text-center border border-gray-200 relative">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold mx-auto mb-4">4</div>
                <h4 class="font-bold">Final</h4>
                <p class="text-xs text-gray-500 mt-2">Disetujui / Ditolak</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6">Validasi Otomatis</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-50 p-3 rounded-lg text-orange-500"><i class="fa-solid fa-database"></i></div>
                    <div>
                        <p class="font-bold text-sm">Jumlah kolam < 3 unit</p>
                        <p class="text-xs text-gray-500">Perlu verifikasi tambahan</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-green-50 p-3 rounded-lg text-green-500"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <p class="font-bold text-sm">Luas lahan > 1 Ha</p>
                        <p class="text-xs text-gray-500">Wajib survei lapangan</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-red-50 p-3 rounded-lg text-red-500"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <p class="font-bold text-sm">Data tidak lengkap</p>
                        <p class="text-xs text-gray-500">Dikembalikan otomatis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="{{ asset('assets/img/features-bg.jpg') }}" alt="Ilustrasi" class="rounded-3xl shadow-lg object-cover h-[400px] w-full">
                <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 bg-white px-6 py-4 rounded-xl shadow-xl w-3/4 flex items-center gap-4">
                    <div class="bg-blue-600 text-white rounded-full p-2">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Usaha pembudidaya yang terdata dalam sistem</p>
                </div>
            </div>

            <div>
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Keunggulan Platform</span>
                <h2 class="text-3xl font-bold mt-4 mb-6">Mengapa Menggunakan Sistem Ini?</h2>
                <p class="text-gray-500 mb-8">Platform yang dirancang khusus untuk memenuhi kebutuhan pendataan dan verifikasi pembudidaya perikanan dengan standar tinggi.</p>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Audit Trail Lengkap</h4>
                            <p class="text-sm text-gray-500">Setiap aktivitas terekam otomatis.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-green-50 text-green-600 w-12 h-12 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Notifikasi Real-Time</h4>
                            <p class="text-sm text-gray-500">Pemberitahuan otomatis ke WhatsApp/Email.</p>
                        </div>
                    </div>
                     <div class="flex gap-4">
                        <div class="bg-yellow-50 text-yellow-600 w-12 h-12 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-map"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Peta GIS Interaktif</h4>
                            <p class="text-sm text-gray-500">Pemetaan lokasi usaha budidaya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-4">Siap Memulai Pendaftaran?</h2>
        <p class="text-blue-100 mb-10 max-w-2xl mx-auto">
            Daftarkan usaha budidaya perikanan Anda sekarang dan dapatkan verifikasi resmi dari Dinas Perikanan.
        </p>

        <div class="flex justify-center gap-4 mb-12">
            <a href="" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition">
                Daftar Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
            <a href="" class="px-8 py-3 bg-transparent border border-white text-white rounded-lg font-bold hover:bg-white/10 transition">
                Sudah Punya Akun? Masuk
            </a>
        </div>

        <div class="grid grid-cols-3 max-w-3xl mx-auto border-t border-white/20 pt-8">
            <div>
                <h4 class="font-bold text-xl">24/7</h4>
                <p class="text-xs text-blue-200">Sistem Online</p>
            </div>
            <div>
                <h4 class="font-bold text-xl">100%</h4>
                <p class="text-xs text-blue-200">Aman & Terenkripsi</p>
            </div>
            <div>
                <h4 class="font-bold text-xl">Gratis</h4>
                <p class="text-xs text-blue-200">Tanpa Biaya</p>
            </div>
        </div>
    </div>
</section>

@endsection