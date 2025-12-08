<?php
// 1. Sertakan file cek login
include '../cek_login.php';

// 2. Cek apakah role-nya = member
if ($_SESSION['role'] != 'member') {
    // Jika bukan member, tendang ke halaman login
    header("location: ../login.php?error=aksesditolak");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Team Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-gray-700 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Member</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        <h2 class="text-3xl font-bold mb-4">Dashboard Team Member</h2>
        <p class="text-gray-700">Selamat datang! Cek daftar tugas Anda dan perbarui statusnya.</p>
        
        <div class="mt-6 grid grid-cols-1 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2">Tugas Saya</h3>
                <p class="text-sm text-gray-600 mb-4">Lihat semua tugas yang diberikan kepada Anda.</p>
                <a href="tugas_saya.php" class="text-gray-800 hover:underline">Lihat tugas ></a>
            </div>
        </div>
    </div>

</body>
</html>