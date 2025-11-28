<?php
// 1. Sertakan file cek login & koneksi
include '../cek_login.php';
include '../koneksi.php';

// 2. Cek Role Super Admin
if ($_SESSION['role'] != 'superadmin') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session
$username_admin = $_SESSION['username'];

// 4. Query untuk mengambil SEMUA proyek dari SEMUA manajer
// Kita JOIN ke 'users' untuk dapat nama manager
// Kita JOIN ke 'tasks' untuk menghitung progres
$sql = "SELECT 
            p.id, 
            p.nama_proyek, 
            p.tanggal_mulai, 
            p.tanggal_selesai,
            u.username AS manager_name,
            COUNT(t.id) AS jumlah_tugas,
            SUM(CASE WHEN t.status = 'selesai' THEN 1 ELSE 0 END) AS tugas_selesai
        FROM 
            projects p
        LEFT JOIN 
            users u ON p.manager_id = u.id
        LEFT JOIN 
            tasks t ON p.id = t.project_id
        GROUP BY
            p.id, p.nama_proyek, p.tanggal_mulai, p.tanggal_selesai, u.username
        ORDER BY
            p.tanggal_mulai DESC";

$result = $koneksi->query($sql);

if (!$result) {
    die("Error mengambil data proyek: " . $koneksi->error);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Proyek - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Super Admin</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username_admin); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        
        <div class="mb-6">
            <a href="dashboard.php" class="text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
        </div>

        <h2 class="text-3xl font-bold mb-5">Monitor Semua Proyek</h2>
        
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progres Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tugas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if ($result->num_rows > 0) {
                        // Loop data
                        while($row = $result->fetch_assoc()) {
                            
                            // Hitung persentase progress
                            $progress = 0;
                            if ($row['jumlah_tugas'] > 0) {
                                // (tugas_selesai / jumlah_tugas) * 100
                                $progress = ($row['tugas_selesai'] / $row['jumlah_tugas']) * 100;
                            }
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($row['nama_proyek']); ?>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo $row['manager_name'] ? htmlspecialchars($row['manager_name']) : '<em>(Manajer Dihapus)</em>'; ?>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div title="Mulai"><?php echo date("d M Y", strtotime($row['tanggal_mulai'])); ?></div>
                            <div title="Selesai" class="text-xs text-gray-500">&rarr; <?php echo date("d M Y", strtotime($row['tanggal_selesai'])); ?></div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-600"><?php echo round($progress, 0); ?>%</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                            <?php echo $row['tugas_selesai']; ?> / <?php echo $row['jumlah_tugas']; ?>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        // Jika tidak ada data
                        echo '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada proyek di sistem.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>

<?php
// 5. Tutup koneksi
$koneksi->close();
?>