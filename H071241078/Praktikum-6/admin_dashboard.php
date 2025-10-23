<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'ADMIN') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Admin Dashboard</h1>
            <div>
                <a href="user.php" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold mr-2 hover:bg-gray-100">
                    Tambah User
                </a>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 space-y-10">

        <!-- DAFTAR USER -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Semua User</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue;

                            $role_color = match($user['role']) {
                                'MANAGER' => 'bg-green-200 text-green-800',
                                'MEMBER' => 'bg-yellow-200 text-yellow-800',
                            };
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-sm <?= $role_color ?>"><?= htmlspecialchars($user['role']) ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="user.php?action=delete&id=<?= $user['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-center text-white px-3 py-1 rounded-md text-sm font-medium">
                                    Hapus
                                    </a>

                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- DAFTAR PROYEK -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Semua Proyek</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Manager</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $project_result = mysqli_query($conn, "
                            SELECT p.*, u.username AS manager 
                            FROM projects p 
                            LEFT JOIN users u ON p.manager_id = u.id
                        ");
                        
                        while ($row = mysqli_fetch_assoc($project_result)) {
                            $members = [];
                            $member_result = mysqli_query($conn, "
                                SELECT username 
                                FROM users 
                                WHERE project_manager_id={$row['manager_id']} 
                                AND role='MEMBER'
                            ");
                            while ($m = mysqli_fetch_assoc($member_result)) {
                                $members[] = $m['username'];
                            }
                            $members_str = implode(', ', $members);
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['manager']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($members_str) ?></td>
                            <td class="px-4 py-3">
                                <a href="crud_proyek.php?hapus_id=<?= $row['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>
