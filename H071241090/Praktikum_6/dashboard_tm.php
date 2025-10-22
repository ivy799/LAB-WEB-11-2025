<?php
session_start();
include("config/config.php"); 

// 🔒 Hanya untuk Team Member
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'team_member') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ✅ Update status tugas (Dengan Prepared Statement dan Otorisasi)
if (isset($_POST['update_status'])) {
    $task_id = intval($_POST['task_id']);
    $status = $_POST['status'];
    $msg = "";

    // Perbaikan: Prepared Statement untuk UPDATE dengan Otorisasi
    // UPDATE hanya dilakukan jika task_id dimiliki oleh assigned_to = $user_id
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("sii", $status, $task_id, $user_id); // 1 string, 2 integer
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $msg = "✅ Status tugas berhasil diperbarui!";
    } else {
        // Ini bisa berarti tugas tidak ada ATAU bukan tugasnya
        $msg = "⚠️ Gagal memperbarui status atau kamu tidak punya akses mengubah tugas ini.";
    }
    $stmt->close();
}
// Catatan: Pengecekan status tugas di awal (blok if) tidak lagi diperlukan karena otorisasi
// sudah diintegrasikan ke dalam query UPDATE.

// ✅ Ambil semua proyek di mana dia ditugaskan (Menggunakan Prepared Statement untuk SELECT)
// Meskipun tidak wajib, ini adalah contoh praktik terbaik
$projects_stmt = $conn->prepare("
    SELECT DISTINCT p.id, p.nama_proyek, p.deskripsi, u.username AS manager_name
    FROM projects p
    JOIN tasks t ON p.id = t.project_id
    JOIN users u ON p.manager_id = u.id
    WHERE t.assigned_to = ?
");
$projects_stmt->bind_param("i", $user_id);
$projects_stmt->execute();
$projects = $projects_stmt->get_result(); // Ambil hasilnya
$projects_stmt->close(); // Tutup statement

// ✅ Ambil semua tugas miliknya (Menggunakan Prepared Statement untuk SELECT)
$tasks_stmt = $conn->prepare("
    SELECT t.*, p.nama_proyek
    FROM tasks t
    JOIN projects p ON t.project_id = p.id
    WHERE t.assigned_to = ?
    ORDER BY t.id DESC
");
$tasks_stmt->bind_param("i", $user_id);
$tasks_stmt->execute();
$tasks = $tasks_stmt->get_result(); // Ambil hasilnya
$tasks_stmt->close(); // Tutup statement

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Team Member</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-green-600 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold">Dashboard Team Member</h1>
    <div>
      <span class="mr-4">Halo, <?= htmlspecialchars($username); ?> 👋</span>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Logout</a>
    </div>
  </nav>

  <main class="p-6">

    <?php if (!empty($msg)): ?>
      <div class="mb-4 p-3 rounded-md <?= str_contains($msg, '✅') ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' ?>">
        <?= $msg; ?>
      </div>
    <?php endif; ?>

    <!-- 🔹 Daftar Proyek -->
    <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Proyek yang Kamu Ikuti</h2>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-green-50 border-b">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nama Proyek</th>
            <th class="border p-2">Deskripsi</th>
            <th class="border p-2">Project Manager</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($projects) > 0): ?>
            <?php while ($p = mysqli_fetch_assoc($projects)): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="border p-2 text-center"><?= $p['id']; ?></td>
                <td class="border p-2"><?= htmlspecialchars($p['nama_proyek']); ?></td>
                <td class="border p-2"><?= htmlspecialchars($p['deskripsi']); ?></td>
                <td class="border p-2 text-center"><?= htmlspecialchars($p['manager_name']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center text-gray-500 p-4">Belum ada proyek yang ditugaskan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- 🔹 Daftar Tugas -->
    <div class="bg-white p-6 rounded-2xl shadow-md">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Tugas Kamu</h2>

      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-green-50 border-b">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nama Proyek</th>
            <th class="border p-2">Judul Tugas</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($tasks) > 0): ?>
            <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="border p-2 text-center"><?= $t['id']; ?></td>
                <td class="border p-2"><?= htmlspecialchars($t['nama_proyek']); ?></td>
                <td class="border p-2"><?= htmlspecialchars($t['nama_tugas']); ?></td>
                <td class="border p-2 text-center">
                  <form method="POST" class="flex justify-center items-center gap-2">
                    <input type="hidden" name="task_id" value="<?= $t['id']; ?>">
                    <select name="status" class="border rounded-md p-1 text-sm">
                      <option value="belum" <?= $t['status'] === 'belum' ? 'selected' : ''; ?>>Belum</option>
                      <option value="proses" <?= $t['status'] === 'proses' ? 'selected' : ''; ?>>Proses</option>
                      <option value="selesai" <?= $t['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                    <button type="submit" name="update_status"
                            class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                      Update
                    </button>
                  </form>
                </td>
                <td class="border p-2 text-center text-gray-500 italic">-</td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-gray-500 p-4">Belum ada tugas untukmu.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>
</html>
