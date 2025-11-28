<?php
// 1. Sertakan file cek login & koneksi
include '../cek_login.php';
include '../koneksi.php';

// 2. Cek Role Manager
if ($_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session
$username_manager = $_SESSION['username'];
$manager_id = $_SESSION['user_id'];

// 4. Validasi Project ID (WAJIB)
// Cek apakah ada project_id di URL
if (!isset($_GET['project_id']) || empty($_GET['project_id'])) {
    header("location: proyek_saya.php?error=noprojectid");
    exit;
}

$project_id = $_GET['project_id'];

// 5. Query untuk memvalidasi proyek & mengambil datanya
// Cek apakah proyek ini ADA dan BENAR-BENAR MILIK manager yang login
$sql_project = "SELECT id, nama_proyek FROM projects WHERE id = ? AND manager_id = ?";
$stmt_project = $koneksi->prepare($sql_project);
$stmt_project->bind_param("ii", $project_id, $manager_id);
$stmt_project->execute();
$result_project = $stmt_project->get_result();

if ($result_project->num_rows == 0) {
    // Proyek tidak ditemukan ATAU bukan milik manager ini
    header("location: proyek_saya.php?error=aksesditolak");
    exit;
}
// Ambil data proyek (kita butuh nama proyeknya)
$project_data = $result_project->fetch_assoc();
$nama_proyek = $project_data['nama_proyek'];
$stmt_project->close();


// 6. Query untuk mengambil daftar team member (milik manager ini)
// Ini untuk mengisi dropdown 'assigned_to'
$sql_members = "SELECT id, username FROM users WHERE role = 'member' AND project_manager_id = ? ORDER BY username";
$stmt_members = $koneksi->prepare($sql_members);
$stmt_members->bind_param("i", $manager_id);
$stmt_members->execute();
$result_members = $stmt_members->get_result();

$team_members = [];
while($row = $result_members->fetch_assoc()) {
    $team_members[] = $row;
}
$stmt_members->close();


// 7. Query untuk mengambil semua tugas (task) untuk proyek ini
// Kita JOIN dengan tabel 'users' untuk mendapatkan 'username' yang ditugaskan
$sql_tasks = "SELECT 
                t.id, 
                t.nama_tugas, 
                t.status, 
                t.assigned_to,
                u.username AS assigned_username
              FROM 
                tasks t
              LEFT JOIN 
                users u ON t.assigned_to = u.id
              WHERE 
                t.project_id = ?
              ORDER BY
                -- Tampilkan yang 'belum' dan 'dikerjakan' dulu
                FIELD(t.status, 'selesai') ASC, 
                t.id DESC";
                
$stmt_tasks = $koneksi->prepare($sql_tasks);
$stmt_tasks->bind_param("i", $project_id);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tugas - <?php echo htmlspecialchars($nama_proyek); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-green-700 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Manager</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username_manager); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        
        <div class="mb-6">
            <a href="proyek_saya.php" class="text-green-600 hover:underline">&larr; Kembali ke Daftar Proyek</a>
        </div>

        <h2 class="text-3xl font-bold mb-1">Kelola Tugas</h2>
        <p class="text-xl text-gray-700 mb-6">Untuk Proyek: <span class="font-semibold"><?php echo htmlspecialchars($nama_proyek); ?></span></p>
        
        <?php
        if (isset($_GET['status'])) {
            $status_msg = '';
            if ($_GET['status'] == 'sukses_tambah') {
                $status_msg = 'Tugas baru berhasil ditambahkan.';
            } elseif ($_GET['status'] == 'sukses_update') {
                $status_msg = 'Tugas berhasil diperbarui.';
            } elseif ($_GET['status'] == 'sukses_hapus') {
                $status_msg = 'Tugas berhasil dihapus.';
            }
            
            if ($status_msg) {
                echo '<div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">';
                echo htmlspecialchars($status_msg);
                echo '</div>';
            }
        }
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-6">
                    <h3 class="text-xl font-bold mb-4">Tambah Tugas Baru</h3>
                    
                    <form action="proses_tugas.php?action=tambah" method="POST">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        
                        <div class="mb-4">
                            <label for="nama_tugas" class="block text-sm font-medium text-gray-700">Nama Tugas</label>
                            <input type="text" id="nama_tugas" name="nama_tugas" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                          focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                            <textarea id="deskripsi" name="deskripsi" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                             focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Tugaskan kepada</label>
                            <select id="assigned_to" name="assigned_to"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                           focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Belum Ditugaskan --</option>
                                <?php
                                if (empty($team_members)) {
                                    echo '<option value="" disabled>Anda belum memiliki team member</option>';
                                } else {
                                    foreach ($team_members as $member) {
                                        echo '<option value="' . $member['id'] . '">' . htmlspecialchars($member['username']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div>
                            <button type="submit" 
                                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                           text-white bg-blue-600 hover:bg-blue-700 
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                    <h3 class="text-xl font-bold mb-4">Daftar Tugas (<?php echo $result_tasks->num_rows; ?>)</h3>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tugas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ditugaskan Kepada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            if ($result_tasks->num_rows > 0) {
                                while($task = $result_tasks->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($task['nama_tugas']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php 
                                    // Tampilkan nama jika ada, jika tidak ('NULL') tampilkan '-'
                                    echo $task['assigned_username'] ? htmlspecialchars($task['assigned_username']) : '<em>(Belum ada)</em>'; 
                                    ?>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="edit_tugas.php?id=<?php echo $task['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <a href="proses_tugas.php?action=hapus&id=<?php echo $task['id']; ?>&project_id=<?php echo $project_id; ?>" 
                                       class="text-red-600 hover:text-red-900"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                       Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada tugas untuk proyek ini.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
    </div>

</body>
</html>

<?php
// 8. Tutup semua statement dan koneksi
$stmt_tasks->close();
$koneksi->close();
?>