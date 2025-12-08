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

// 4. Cek apakah ada ID Tugas di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: proyek_saya.php?error=noid");
    exit;
}

$task_id = $_GET['id'];

// 5. Query untuk mengambil data tugas (DAN validasi kepemilikan)
// Kita JOIN ke tabel 'projects' untuk memastikan 'manager_id' di proyek
// sama dengan 'manager_id' di session.
$sql_task = "SELECT 
                t.*,
                p.manager_id 
             FROM 
                tasks t
             JOIN 
                projects p ON t.project_id = p.id
             WHERE 
                t.id = ? AND p.manager_id = ?";
                
$stmt_task = $koneksi->prepare($sql_task);
$stmt_task->bind_param("ii", $task_id, $manager_id);
$stmt_task->execute();
$result_task = $stmt_task->get_result();

if ($result_task->num_rows == 0) {
    // Tugas tidak ditemukan ATAU bukan milik manager ini
    header("location: proyek_saya.php?error=aksesditolak_tugas");
    exit;
}
// Ambil data tugas
$task_data = $result_task->fetch_assoc();
$project_id_asal = $task_data['project_id']; // Kita simpan untuk link 'Kembali'
$stmt_task->close();


// 6. Query untuk mengambil daftar team member (milik manager ini)
// (Sama seperti di halaman kelola_tugas.php)
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
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas - Project Manager</title>
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
            <a href="kelola_tugas.php?project_id=<?php echo $project_id_asal; ?>" class="text-green-600 hover:underline">
                &larr; Kembali ke Daftar Tugas
            </a>
        </div>

        <h2 class="text-3xl font-bold mb-4">Edit Tugas</h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
            
            <form action="proses_tugas.php?action=edit" method="POST">
                <input type="hidden" name="id" value="<?php echo $task_data['id']; ?>">
                <input type="hidden" name="project_id" value="<?php echo $task_data['project_id']; ?>">
                
                <div class="mb-4">
                    <label for="nama_tugas" class="block text-sm font-medium text-gray-700">Nama Tugas</label>
                    <input type="text" id="nama_tugas" name="nama_tugas" required
                           value="<?php echo htmlspecialchars($task_data['nama_tugas']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                     focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($task_data['deskripsi']); ?></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Tugas</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="belum" <?php echo ($task_data['status'] == 'belum') ? 'selected' : ''; ?>>Belum Dikerjakan</option>
                        <option value="dikerjakan" <?php echo ($task_data['status'] == 'dikerjakan') ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                        <option value="selesai" <?php echo ($task_data['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="assigned_to" class="block text-sm font-medium text-gray-700">Tugaskan kepada</label>
                    <select id="assigned_to" name="assigned_to"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Belum Ditugaskan --</option>
                        <?php
                        foreach ($team_members as $member) {
                            // Cek apakah member ini adalah yang sedang ditugaskan
                            $selected = ($task_data['assigned_to'] == $member['id']) ? 'selected' : '';
                            echo '<option value="' . $member['id'] . '" ' . $selected . '>';
                            echo htmlspecialchars($member['username']);
                            echo '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                   text-white bg-indigo-600 hover:bg-indigo-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Tugas
                    </button>
                </div>
            </form>
        </div>
        
    </div>

</body>
</html>