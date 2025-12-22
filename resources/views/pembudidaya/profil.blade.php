@extends('layouts.pembudidaya')

@section('title', 'Profil & Detail Usaha Budidaya')
@section('subtitle', 'Kelola dan perbarui Data Pembudidaya serta Detail Usaha Budidaya Anda')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="font-bold text-gray-800 text-lg mb-6 border-b border-gray-100 pb-4">1. Data Diri Pembudidaya</h3>
    
   <form action="{{ route('pembudidaya.profil.update') }}" method="POST"> 
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">NIK</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-regular fa-id-card"></i>
                    </span>
                    <input type="text" name="NIK" value="{{ $user->profil->NIK ?? '' }}" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" name="nama" value="{{ $user->profil->nama ?? '' }}" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-regular fa-file-lines"></i>
                    </span>
                    <input type="email" 
                        name="email" 
                        value="{{ $user->email ?? '' }}" 
                        class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100 text-gray-500 cursor-not-allowed" 
                        readonly>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Email tidak dapat diubah. Hubungi admin jika ingin mengganti.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">No. Telepon</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <input type="text" name="nomor_hp" value="{{ $user->nomor_hp ?? '' }}" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-600 mb-2">Alamat</label>
            <div class="relative">
                <span class="absolute top-3 left-3 text-gray-400">
                    <i class="fa-regular fa-building"></i>
                </span>
                <textarea name="alamat" rows="3" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan alamat lengkap usaha...">{{ $user->alamat ?? '' }}</textarea>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 text-sm">
            Simpan Data Diri
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 text-lg mb-6 border-b border-gray-100 pb-4">2. Detail Usaha Budidaya</h3>
    
    <form action="{{ route('pembudidaya.profil.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Komoditas Utama</label>
                <div class="relative">
                    <select name="jenis_ikan" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
                        <option value="Udang" {{ ($user->profil->usaha->jenis_ikan ?? '') == 'Udang' ? 'selected' : '' }}>Udang</option>
                        <option value="Lele" {{ ($user->profil->usaha->jenis_ikan ?? '') == 'Lele' ? 'selected' : '' }}>Lele</option>
                        <option value="Nila" {{ ($user->profil->usaha->jenis_ikan ?? '') == 'Nila' ? 'selected' : '' }}>Nila</option>
                        <option value="Bandeng" {{ ($user->profil->usaha->jenis_ikan ?? '') == 'Bandeng' ? 'selected' : '' }}>Bandeng</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Luas Lahan (m²)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-expand"></i> </span>
                    <input type="number" name="luas_kolam" value="{{ $user->profil->usaha->luas_kolam ?? '' }}" placeholder="Contoh: 1000" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600 mb-2">Tipe Kolam</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    <input type="text" name="tipe_kolam" value="{{ $user->profil->usaha->tipe_kolam ?? '' }}" placeholder="Tambak Intensif" class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 text-sm">
            Simpan Detail Usaha
        </button>
    </form>
</div>

@endsection