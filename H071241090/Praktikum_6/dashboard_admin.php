<?php
session_start();
include("config/config.php");

// 🔒 Pastikan hanya Super Admin yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: login.php");
    exit;
}

// ======== HAPUS USER (Menggunakan Prepared Statement) ========
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);
    
    // Perbaikan: Prepared Statement untuk DELETE
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' untuk integer
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_admin.php");
    exit;
}

// ======== HAPUS PROYEK (Menggunakan Prepared Statement) ========
if (isset($_GET['delete_project'])) {
    $id = intval($_GET['delete_project']);
    
    // Perbaikan: Prepared Statement untuk DELETE
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_admin.php");
    exit;
}

// ======== TAMBAH PROJECT MANAGER (Menggunakan Prepared Statement) ========
if (isset($_POST['add_pm'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'project_manager'; // Nilai tetap
    $msg = "";
    
    // Perbaikan: Prepared Statement untuk INSERT
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role); // 'sss' untuk 3 string
    $insert = $stmt->execute();
    $stmt->close();

    $msg = $insert ? "✅ Project Manager '$username' berhasil ditambahkan."
                   : "❌ Gagal menambahkan Project Manager.";
}

// ======== TAMBAH TEAM MEMBER (Menggunakan Prepared Statement) ========
if (isset($_POST['add_tm'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $pm_id = intval($_POST['pm_id']);
    $role = 'team_member'; // Nilai tetap
    $msg = "";

    // Perbaikan: Prepared Statement untuk INSERT
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $role, $pm_id); // 'sssi' untuk 3 string dan 1 integer
    $insert = $stmt->execute();
    $stmt->close();
    
    $msg = $insert ? "✅ Team Member '$username' berhasil ditambahkan."
                   : "❌ Gagal menambahkan Team Member.";
}

// ======== AMBIL SEMUA USER (Tidak perlu perbaikan, karena tidak ada input user) ========
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role, username");

// ======== AMBIL DAFTAR PM UNTUK DROPDOWN (Tidak perlu perbaikan) ========
$pm_role = 'project_manager';
$pm_list_stmt = $conn->prepare("SELECT id, username FROM users WHERE role = ?");
$pm_list_stmt->bind_param("s", $pm_role);
$pm_list_stmt->execute();
$pm_list = $pm_list_stmt->get_result();
$pm_list_stmt->close(); // Pastikan statement ditutup

// ======== AMBIL SEMUA PROYEK DARI SEMUA PM ========
$projects = mysqli_query($conn, "
    SELECT p.id, p.nama_proyek, p.deskripsi, u.username AS manager_name
    FROM projects p
    JOIN users u ON p.manager_id = u.id
    ORDER BY p.created_at DESC
");


?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Super Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold">Dashboard Super Admin</h1>
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

    <!-- 🔹 DAFTAR SEMUA USER -->
    <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Daftar Pengguna</h2>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-blue-50 border-b">
            <th class="border p-2">ID</th>
            <th class="border p-2">Username</th>
            <th class="border p-2">Role</th>
            <th class="border p-2">Project Manager</th>
            <th class="border p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($users)): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="border p-2 text-center"><?= $user['id']; ?></td>
              <td class="border p-2"><?= htmlspecialchars($user['username']); ?></td>
              <td class="border p-2 text-center"><?= $user['role']; ?></td>
              <td class="border p-2 text-center">
                <?php
                  if ($user['project_manager_id']) {
                      $pm_id_for_tm = $user['project_manager_id'];
                      
                      // Perbaikan: Prepared Statement untuk mencari PM Name
                      $pm_stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
                      $pm_stmt->bind_param("i", $pm_id_for_tm);
                      $pm_stmt->execute();
                      $pm_result = $pm_stmt->get_result();
                      
                      if ($pm_name = mysqli_fetch_assoc($pm_result)) {
                          echo htmlspecialchars($pm_name['username']);
                      }
                      $pm_stmt->close(); // PASTIKAN DITUTUP di dalam loop
                  } else {
                      echo "-";
                  }
                ?>
              </td>
              <td class="border p-2 text-center">
                <?php if ($user['role'] !== 'super_admin'): ?>
                  <a href="?delete_user=<?= $user['id']; ?>"
                     class="text-red-600 hover:underline"
                     onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                <?php else: ?>
                  <span class="text-gray-400 italic">tidak dapat dihapus</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- 🔹 FORM TAMBAH USER -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">

      <!-- Tambah Project Manager -->
      <div class="bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah Project Manager</h2>
        <form method="POST" class="space-y-4">
          <div>
            <label class="block text-gray-600">Username</label>
            <input type="text" name="username" required class="w-full border rounded-md p-2">
          </div>
          <div>
            <label class="block text-gray-600">Password</label>
            <input type="password" name="password" required class="w-full border rounded-md p-2">
          </div>
          <button type="submit" name="add_pm"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Tambah Project Manager
          </button>
        </form>
      </div>

      <!-- Tambah Team Member -->
      <div class="bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah Team Member</h2>
        <form method="POST" class="space-y-4">
          <div>
            <label class="block text-gray-600">Username</label>
            <input type="text" name="username" required class="w-full border rounded-md p-2">
          </div>
          <div>
            <label class="block text-gray-600">Password</label>
            <input type="password" name="password" required class="w-full border rounded-md p-2">
          </div>
          <div>
            <label class="block text-gray-600">Pilih Project Manager</label>
            <select name="pm_id" required class="w-full border rounded-md p-2">
              <option value="">-- Pilih PM --</option>
              <?php while ($pm = mysqli_fetch_assoc($pm_list)): ?>
                <option value="<?= $pm['id']; ?>"><?= htmlspecialchars($pm['username']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <button type="submit" name="add_tm"
                  class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
            Tambah Team Member
          </button>
        </form>
      </div>

    </div>

    <!-- 🔹 DAFTAR SEMUA PROYEK -->
    <div class="bg-white p-6 rounded-2xl shadow-md">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Semua Proyek</h2>

      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-blue-50 border-b">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nama Proyek</th>
            <th class="border p-2">Deskripsi</th>
            <th class="border p-2">Project Manager</th>
            <th class="border p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($projects)): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="border p-2 text-center"><?= $p['id']; ?></td>
              <td class="border p-2"><?= htmlspecialchars($p['nama_proyek']); ?></td>
              <td class="border p-2"><?= htmlspecialchars($p['deskripsi']); ?></td>
              <td class="border p-2 text-center"><?= htmlspecialchars($p['manager_name']); ?></td>
              <td class="border p-2 text-center">
                <a href="?delete_project=<?= $p['id']; ?>"
                   class="text-red-600 hover:underline"
                   onclick="return confirm('Yakin ingin menghapus proyek ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>
</html>
