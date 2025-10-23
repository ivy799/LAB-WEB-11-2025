<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Mulai sesi terlebih dahulu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Sertakan koneksi database, sehingga variabel $conn pasti tersedia
include("config/config.php"); 

// 🔒 Hanya Project Manager yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'project_manager') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

// ===================================================
// =============== CRUD PROYEK (Dengan Prepared Statement) =================
// ===================================================

// Tambah proyek
if (isset($_POST['add_project'])) {
    $nama = trim($_POST['nama_proyek']);
    $desc = trim($_POST['deskripsi']);
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    // Perbaikan: Prepared Statement untuk INSERT
    $stmt = $conn->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama, $desc, $tgl_mulai, $tgl_selesai, $user_id); // 4 string, 1 integer
    $insert = $stmt->execute();
    $stmt->close();

    $msg = $insert ? "✅ Proyek '$nama' berhasil ditambahkan." : "❌ Gagal menambahkan proyek.";
}

// Edit proyek
if (isset($_POST['edit_project'])) {
    $id = intval($_POST['project_id']);
    $nama = trim($_POST['nama_proyek']);
    $desc = trim($_POST['deskripsi']);
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    // Perbaikan: Prepared Statement untuk UPDATE
    $stmt = $conn->prepare("UPDATE projects 
                           SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?
                           WHERE id=? AND manager_id=?");
    // 4 string, 2 integer
    $stmt->bind_param("ssssii", $nama, $desc, $tgl_mulai, $tgl_selesai, $id, $user_id); 
    $update = $stmt->execute();
    $stmt->close();

    $msg = $update ? "✅ Proyek berhasil diubah." : "❌ Gagal mengubah proyek.";
}

// Hapus proyek
if (isset($_GET['delete_project'])) {
    $id = intval($_GET['delete_project']);
    
    // Perbaikan: Prepared Statement untuk DELETE Tasks
    $stmt_task = $conn->prepare("DELETE FROM tasks WHERE project_id=? AND project_id IN (SELECT id FROM projects WHERE manager_id=?)");
    $stmt_task->bind_param("ii", $id, $user_id);
    $stmt_task->execute();
    $stmt_task->close();

    // Perbaikan: Prepared Statement untuk DELETE Project
    $stmt_proj = $conn->prepare("DELETE FROM projects WHERE id=? AND manager_id=?");
    $stmt_proj->bind_param("ii", $id, $user_id);
    $stmt_proj->execute();
    $stmt_proj->close();
    
    header("Location: dashboard_pm.php");
    exit;
}

// ===================================================
// =============== CRUD TUGAS (Dengan Prepared Statement) =================
// ===================================================

// Tambah tugas
if (isset($_POST['add_task'])) {
    $project_id = intval($_POST['project_id']);
    $title = trim($_POST['title']);
    $status = 'belum';
    $assigned = intval($_POST['assigned_to']);

    // Perbaikan: Prepared Statement untuk INSERT
    $stmt = $conn->prepare("INSERT INTO tasks (nama_tugas, status, project_id, assigned_to) VALUES (?, ?, ?, ?)");
    // 2 string, 2 integer
    $stmt->bind_param("ssii", $title, $status, $project_id, $assigned); 
    $insert = $stmt->execute();
    $stmt->close();
    
    $msg = $insert ? "✅ Tugas '$title' berhasil ditambahkan." : "❌ Gagal menambahkan tugas.";
}

// Ubah status tugas
if (isset($_POST['update_status'])) {
    $task_id = intval($_POST['task_id']);
    $status = $_POST['status'];
    
    // Perbaikan: Prepared Statement untuk UPDATE
    $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $task_id); // 1 string, 1 integer
    $update = $stmt->execute();
    $stmt->close();

    $msg = $update ? "✅ Status tugas diperbarui." : "❌ Gagal memperbarui status.";
}

// Hapus tugas
if (isset($_GET['delete_task'])) {
    $id = intval($_GET['delete_task']);
    
    // Perbaikan: Prepared Statement untuk DELETE
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND project_id IN (SELECT id FROM projects WHERE manager_id=?)");
    $stmt->bind_param("ii", $id, $user_id); // Tambahkan otorisasi PM
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_pm.php");
    exit;
}

// ===================================================
// =================== AMBIL DATA ====================
// ===================================================

$projects = mysqli_query($conn, "SELECT * FROM projects WHERE manager_id=$user_id");
$team_members = mysqli_query($conn, "SELECT id, username FROM users WHERE project_manager_id=$user_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Project Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold">Dashboard Project Manager</h1>
    <div>
      <span class="mr-4">Halo, <?= $_SESSION['username']; ?> 👋</span>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Logout</a>
    </div>
  </nav>

  <main class="p-6">

    <?php if (!empty($msg)): ?>
      <div class="mb-4 p-3 rounded-md <?= str_contains($msg, '✅') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
        <?= $msg; ?>
      </div>
    <?php endif; ?>

    <!-- ===== FORM TAMBAH PROYEK ===== -->
    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah Proyek Baru</h2>
      <form method="POST" class="grid md:grid-cols-2 gap-3">
        <input type="text" name="nama_proyek" placeholder="Nama proyek" required class="border p-2 rounded">
        <input type="text" name="deskripsi" placeholder="Deskripsi proyek" required class="border p-2 rounded">
        <input type="date" name="tanggal_mulai" required class="border p-2 rounded">
        <input type="date" name="tanggal_selesai" required class="border p-2 rounded">
        <button type="submit" name="add_project" class="bg-blue-600 text-white px-4 py-2 rounded mt-2 md:col-span-2">
          Tambah Proyek
        </button>
      </form>
    </div>

    <!-- ===== DAFTAR PROYEK ===== -->
    <?php while ($p = mysqli_fetch_assoc($projects)): ?>
      <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($p['nama_proyek'] ?? ''); ?></h2>
          <a href="?delete_project=<?= $p['id']; ?>" class="text-red-600 hover:underline"
             onclick="return confirm('Hapus proyek ini beserta tugasnya?')">Hapus</a>
        </div>
        <p class="text-gray-600 mb-3"><?= htmlspecialchars($p['deskripsi'] ?? ''); ?></p>
        <p class="text-sm text-gray-500 mb-3">
          Mulai: <?= htmlspecialchars($p['tanggal_mulai'] ?? '-'); ?> |
          Selesai: <?= htmlspecialchars($p['tanggal_selesai'] ?? '-'); ?>
        </p>

        <!-- ===== FORM EDIT PROYEK ===== -->
        <form method="POST" class="grid md:grid-cols-2 gap-3 mb-4">
          <input type="hidden" name="project_id" value="<?= $p['id']; ?>">
          <input type="text" name="nama_proyek" value="<?= htmlspecialchars($p['nama_proyek'] ?? ''); ?>" class="border p-2 rounded">
          <input type="text" name="deskripsi" value="<?= htmlspecialchars($p['deskripsi'] ?? ''); ?>" class="border p-2 rounded">
          <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($p['tanggal_mulai'] ?? ''); ?>" class="border p-2 rounded">
          <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($p['tanggal_selesai'] ?? ''); ?>" class="border p-2 rounded">
          <button type="submit" name="edit_project" class="bg-yellow-500 text-white px-4 py-2 rounded md:col-span-2">Edit Proyek</button>
        </form>

        <!-- ===== FORM TAMBAH TUGAS ===== -->
        <form method="POST" class="flex flex-col md:flex-row gap-3 mb-4">
          <input type="hidden" name="project_id" value="<?= $p['id']; ?>">
          <input type="text" name="title" placeholder="Judul Tugas" required class="border p-2 rounded w-full md:w-1/3">
          <select name="assigned_to" required class="border p-2 rounded w-full md:w-1/3">
            <option value="">-- Pilih Team Member --</option>
            <?php
            mysqli_data_seek($team_members, 0);
            while ($tm = mysqli_fetch_assoc($team_members)): ?>
              <option value="<?= $tm['id']; ?>"><?= htmlspecialchars($tm['username']); ?></option>
            <?php endwhile; ?>
          </select>
          <button type="submit" name="add_task" class="bg-green-600 text-white px-4 py-2 rounded">Tambah Tugas</button>
        </form>

        <!-- ===== DAFTAR TUGAS ===== -->
        <?php
        $tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE project_id = {$p['id']}");
        ?>
        <table class="w-full border-collapse text-sm">
          <thead>
            <tr class="bg-blue-50 border-b">
              <th class="border p-2">Judul</th>
              <th class="border p-2">Status</th>
              <th class="border p-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="border p-2"><?= htmlspecialchars($t['nama_tugas']); ?></td>
                <td class="border p-2 text-center">
                  <form method="POST">
                    <input type="hidden" name="task_id" value="<?= $t['id']; ?>">
                    <select name="status" onchange="this.form.submit()" class="border p-1 rounded">
                      <option <?= $t['status'] == 'belum' ? 'selected' : ''; ?>>belum</option>
                      <option <?= $t['status'] == 'proses' ? 'selected' : ''; ?>>proses</option>
                      <option <?= $t['status'] == 'selesai' ? 'selected' : ''; ?>>selesai</option>
                    </select>
                    <input type="hidden" name="update_status" value="1">
                  </form>
                </td>
                <td class="border p-2 text-center">
                  <a href="?delete_task=<?= $t['id']; ?>" class="text-red-600 hover:underline"
                     onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endwhile; ?>

  </main>
</body>
</html>
