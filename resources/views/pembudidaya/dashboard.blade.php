<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembudidaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h1>
        <p class="mb-4">Anda berhasil login sebagai <strong>{{ Auth::user()->role }}</strong>.</p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Keluar (Logout)
            </button>
        </form>
    </div>
</body>
</html>