<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MANAGER') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];

// =========================
// Hitung total proyek
// =========================
$sql = "SELECT COUNT(*) as total_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_proyek = mysqli_fetch_assoc($result)['total_proyek'] ?? 0;

// =========================
// Hitung total tugas
// =========================
$sql = "SELECT COUNT(*) as total_tugas FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_tugas = mysqli_fetch_assoc($result)['total_tugas'] ?? 0;

// =========================
// Hitung status tugas
// =========================
$status = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

$sql = "SELECT status, COUNT(*) as jumlah 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=? 
        GROUP BY status";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $status[$row['status']] = $row['jumlah'];
}

// =========================
// Ambil daftar proyek
// =========================
$sql = "SELECT * FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$projects = [];
while ($p = mysqli_fetch_assoc($result)) {
    $projects[] = $p;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">

    <header class="bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg 
                   p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-center gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Dashboard Manager</h1>

        <div class="flex flex-wrap gap-2 sm:gap-3">
            <a href="crud_proyek.php"
               class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-md font-semibold transition">
               Tambah Proyek
            </a>
            <a href="logout.php"
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold transition">
               Logout
            </a>
        </div>
    </header>

    <main class="p-4 sm:p-6 max-w-7xl mx-auto">

        <section class="mb-8">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4">Ringkasan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow p-5 text-center hover:shadow-lg transition">
                    <h3 class="text-gray-500 font-medium">Jumlah Proyek</h3>
                    <p class="text-2xl font-bold text-gray-800"><?= $total_proyek ?></p>
                </div>

                <div class="bg-white rounded-xl shadow p-5 text-center hover:shadow-lg transition">
                    <h3 class="text-gray-500 font-medium">Jumlah Tugas</h3>
                    <p class="text-2xl font-bold text-gray-800"><?= $total_tugas ?></p>
                </div>

                <div class="bg-white rounded-xl shadow p-5 text-center hover:shadow-lg transition">
                    <h3 class="text-gray-500 font-medium">Status Tugas</h3>
                    <p class="text-sm text-gray-700">Belum: <?= $status['belum'] ?></p>
                    <p class="text-sm text-gray-700">Proses: <?= $status['proses'] ?></p>
                    <p class="text-sm text-gray-700">Selesai: <?= $status['selesai'] ?></p>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4">Daftar Proyek</h2>

            <?php if (count($projects) === 0): ?>
                <p class="text-gray-600">Belum ada proyek.</p>
            <?php else: ?>
                <div class="overflow-x-auto bg-white rounded-xl shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Proyek
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Mulai
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Selesai
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800 font-medium">
                                        <?= htmlspecialchars($p['nama_proyek']) ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($p['deskripsi']) ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($p['tanggal_mulai']) ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        <?= htmlspecialchars($p['tanggal_selesai']) ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap flex flex-wrap gap-2">
                                       <a href="crud_proyek.php?edit_id=<?= $p['id'] ?>"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md transition">
                                        Edit
                                        </a>

                                        </a>
                                        <a href="crud_proyek.php?hapus_id=<?= $p['id'] ?>"
                                            onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition">
                                            Hapus
                                            </a>

                                        </a>
                                        <a href="crud_tugas.php?project_id=<?= $p['id'] ?>"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md transition">
                                           Tugas
                                        </a>
                                    </td>
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
