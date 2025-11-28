<?php
// 1. Sertakan file cek login & koneksi
include '../cek_login.php';
include '../koneksi.php';

// 2. Cek Role Member
if ($_SESSION['role'] != 'member') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session
$username_member = $_SESSION['username'];
$member_id = $_SESSION['user_id']; // ID member yang sedang login

// 4. Query untuk mengambil TUGAS SAYA
// Kita JOIN ke 'projects' untuk dapat nama proyek
// Kita JOIN ke 'users' (sebagai 'u') untuk dapat nama manager
$sql_tasks = "SELECT 
                t.id, 
                t.nama_tugas, 
                t.deskripsi, 
                t.status,
                p.nama_proyek,
                u.username AS manager_name
            FROM 
                tasks t
            JOIN 
                projects p ON t.project_id = p.id
            JOIN 
                users u ON p.manager_id = u.id
            WHERE 
                t.assigned_to = ?  -- INI FILTER KUNCINYA
            ORDER BY
                -- Tampilkan yang 'selesai' di paling bawah
                FIELD(t.status, 'selesai') ASC, 
                t.id DESC";
                
$stmt_tasks = $koneksi->prepare($sql_tasks);
if ($stmt_tasks === false) {
    die("Error persiapan query: " . $koneksi->error);
}

$stmt_tasks->bind_param("i", $member_id);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Saya - Team Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-gray-700 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Member</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username_member); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        
        <div class="mb-6">
            <a href="dashboard.php" class="text-gray-800 hover:underline">&larr; Kembali ke Dashboard</a>
        </div>

        <h2 class="text-3xl font-bold mb-5">Tugas Saya</h2>
        
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'sukses_update') {
            echo '<div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">';
            echo 'Status tugas berhasil diperbarui.';
            echo '</div>';
        }
        ?>

        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if ($result_tasks->num_rows > 0) {
                        while($task = $result_tasks->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($task['nama_tugas']); ?></div>
                            <div class="text-xs text-gray-500 w-64 truncate" title="<?php echo htmlspecialchars($task['deskripsi']); ?>">
                                <?php echo htmlspecialchars($task['deskripsi']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($task['nama_proyek']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($task['manager_name']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php 
                            $status_badge = '';
                            if ($task['status'] == 'selesai') {
                                $status_badge = 'bg-green-100 text-green-800';
                            } elseif ($task['status'] == 'dikerjakan') {
                                $status_badge = 'bg-yellow-100 text-yellow-800';
                            } else { // 'belum'
                                $status_badge = 'bg-gray-100 text-gray-800';
                            }
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $status_badge; ?>">
                                <?php echo htmlspecialchars(ucfirst($task['status'])); ?>
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="proses_update_status.php" method="POST" class="flex items-center space-x-2">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                
                                <select name="new_status" 
                                        class="block w-36 text-sm border-gray-300 rounded-md shadow-sm 
                                               focus:border-blue-500 focus:ring-blue-500">
                                    <option value="belum" <?php echo ($task['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                    <option value="dikerjakan" <?php echo ($task['status'] == 'dikerjakan') ? 'selected' : ''; ?>>Dikerjakan</option>
                                    <option value="selesai" <?php echo ($task['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                                
                                <button type="submit" 
                                        class="px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm 
                                               text-white bg-blue-600 hover:bg-blue-700 
                                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    OK
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        // Jika tidak ada tugas
                        echo '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Anda tidak memiliki tugas yang ditugaskan saat ini.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>

<?php
// 5. Tutup statement dan koneksi
$stmt_tasks->close();
$koneksi->close();
?>