<?php  
session_start();
require 'koneksi.php';

// ==================================
// CEK AKSES MEMBER
// ==================================
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MEMBER') {
    die("Akses ditolak");
}

$id_member = $_SESSION['user']['id'];

// ==================================
// DAFTAR TUGAS YANG DITUGASKAN
// ==================================
$sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek 
        FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.assigned_to = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tasks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}
mysqli_stmt_close($stmt);

// ==================================
// CEK MANAGER DARI MEMBER
// ==================================
$sql = "SELECT project_manager_id FROM users WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $manager_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// ==================================
// AMBIL DAFTAR PROYEK DARI MANAGER
// ==================================
$projects = [];
if ($manager_id) {
    $sql = "SELECT p.id, p.nama_proyek, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai, u.username AS nama_manager
            FROM projects p
            JOIN users u ON p.manager_id = u.id
            WHERE p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">

    <header class="w-full bg-blue-600 text-white p-4 sm:p-6 flex justify-between items-center shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Member</h1>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-base sm:text-lg transition">
            Logout
        </a>
    </header>

    <main class="w-full p-4 sm:p-6 space-y-10">

        <!-- DAFTAR TUGAS -->
        <section>
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">Tugas Saya</h2>

            <?php if (empty($tasks)) : ?>
                <p class="text-gray-600 text-center text-lg sm:text-xl">
                    Belum ada tugas yang ditugaskan.
                </p>
            <?php else : ?>
                <div class="space-y-4">
                    <?php foreach ($tasks as $tugas) : ?>
                        <div class="bg-white rounded-xl shadow-lg p-5 flex justify-between items-center hover:shadow-2xl transition">
                            <div>
                                <p class="font-semibold text-gray-800 text-lg sm:text-xl">
                                    <?= htmlspecialchars($tugas['nama_tugas']) ?>
                                </p>
                                <p class="text-sm sm:text-base text-gray-500">
                                    <?= htmlspecialchars($tugas['nama_proyek']) ?>
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <?php
                                    $warna = '';
                                    if ($tugas['status'] === 'belum') {
                                        $warna = 'bg-red-200 text-red-800';
                                    } elseif ($tugas['status'] === 'proses') {
                                        $warna = 'bg-yellow-200 text-yellow-800';
                                    } elseif ($tugas['status'] === 'selesai') {
                                        $warna = 'bg-green-200 text-green-800';
                                    }
                                ?>
                                <span class="px-3 py-1 text-sm sm:text-base rounded <?= $warna ?>">
                                    <?= ucfirst($tugas['status']) ?>
                                </span>

                                <a href="crud_tugas.php?id=<?= $tugas['id'] ?>" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-base sm:text-lg transition">
                                    Ubah Status
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- DAFTAR PROYEK -->
        <section>
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">Daftar Proyek</h2>

            <?php if (empty($projects)) : ?>
                <p class="text-gray-600 text-center text-lg sm:text-xl">
                    Belum ada proyek yang terdaftar.
                </p>
            <?php else : ?>
                <div class="overflow-x-auto bg-white rounded-xl shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="px-3 py-2 text-gray-600"><?= htmlspecialchars($p['deskripsi'] ?? '-') ?></td>
                                    <td class="px-3 py-2 text-gray-700"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                    <td class="px-3 py-2 text-gray-700"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                    <td class="px-3 py-2 text-gray-700"><?= htmlspecialchars($p['nama_manager']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>
