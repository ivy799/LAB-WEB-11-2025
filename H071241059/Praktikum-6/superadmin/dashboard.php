<?php
// 1. Sertakan file cek login (wajib ada di paling atas)
// Ini akan memeriksa apakah user sudah login atau belum
include '../cek_login.php';

// 2. Cek apakah role-nya = superadmin
// Ini untuk mencegah role 'manager' atau 'member' mengakses halaman ini
if ($_SESSION['role'] != 'superadmin') {
    // Jika bukan superadmin, tendang ke halaman login
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// Jika lolos kedua cek di atas, ambil data dari session
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Super Admin</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        <h2 class="text-3xl font-bold mb-4">Dashboard Super Admin</h2>
        <p class="text-gray-700">Selamat datang di halaman manajemen. Anda memiliki hak akses penuh atas sistem.</p>
        
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2">Kelola Pengguna</h3>
                <p class="text-sm text-gray-600 mb-4">Tambah, edit, dan hapus data pengguna (manager & member).</p>
                <a href="kelola_user.php" class="text-blue-600 hover:underline">Pergi ke halaman ></a>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2">Lihat Semua Proyek</h3>
                <p class="text-sm text-gray-600 mb-4">Monitor semua proyek yang sedang berjalan.</p>
                <a href="semua_proyek.php" class="text-blue-600 hover:underline">Pergi ke halaman ></a>
            </div>
        </div>
    </div>

</body>
</html>