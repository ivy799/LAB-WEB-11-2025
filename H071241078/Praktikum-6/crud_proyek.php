<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$user_role = $_SESSION['user']['role'];
$user_id = $_SESSION['user']['id'];
$pemberitahuan = "";

// ==========================
// HAPUS PROYEK
// ==========================
if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];

    if ($user_role === 'MANAGER') {
        $sql = "DELETE FROM projects WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $user_id);
    } elseif ($user_role === 'ADMIN') {
        $sql = "DELETE FROM projects WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $hapus_id);
    } else {
        die("Akses ditolak");
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($user_role === 'MANAGER') {
        header("Location: manager_dashboard.php");
    } else {
        header("Location: admin_dashboard.php");
    }
    exit();
}

// ==========================
// TAMBAH PROYEK (MANAGER ONLY)
// ==========================
if ($user_role === 'MANAGER' && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM projects WHERE nama_proyek=? AND manager_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama, $user_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Nama proyek '$nama' sudah ada!";
        } else {
            $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Proyek '$nama' berhasil ditambahkan.";
        }
    }
}

// ==========================
// UPDATE PROYEK (MANAGER ONLY)
// ==========================
if ($user_role === 'MANAGER' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $sql = "UPDATE projects 
                SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?
                WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $nama, $deskripsi, $mulai, $selesai, $id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $pemberitahuan = "Proyek berhasil diperbarui.";
    }
}

// ==========================
// AMBIL DATA PROYEK UNTUK EDIT (MANAGER ONLY)
// ==========================
$edit_data = null;
if ($user_role === 'MANAGER' && isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $sql = "SELECT * FROM projects WHERE id=? AND manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $edit_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
        if ($user_role === 'MANAGER') {
            echo $edit_data ? 'Edit Proyek' : 'Tambah Proyek';
        } else {
            echo 'Hapus Proyek';
        }
        ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center p-6">
    <?php if ($user_role === 'MANAGER'): ?>
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
            <?= $edit_data ? 'Edit Proyek' : 'Tambah Proyek' ?>
        </h1>

        <a href="manager_dashboard.php" class="text-blue-600 hover:underline block mb-4">&larr; Kembali ke Dashboard</a>

        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Proyek:</label>
                <input type="text" name="nama_proyek" required
                       value="<?= htmlspecialchars($edit_data['nama_proyek'] ?? '') ?>"
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Deskripsi:</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($edit_data['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_mulai'] ?? '') ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai:</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_selesai'] ?? '') ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
                <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Proyek' ?>
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Hanya Bisa Hapus Proyek</h1>
        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
    </div>
    <?php endif; ?>

    <script>
        const mulaiInput = document.getElementById('tanggal_mulai');
        const selesaiInput = document.getElementById('tanggal_selesai');

        if (mulaiInput && selesaiInput) {
            mulaiInput.addEventListener('change', () => {
                selesaiInput.min = mulaiInput.value;
                if (selesaiInput.value < mulaiInput.value) selesaiInput.value = mulaiInput.value;
            });

            selesaiInput.addEventListener('change', () => {
                mulaiInput.max = selesaiInput.value;
                if (mulaiInput.value > selesaiInput.value) mulaiInput.value = selesaiInput.value;
            });

            if (mulaiInput.value) selesaiInput.min = mulaiInput.value;
            if (selesaiInput.value) mulaiInput.max = selesaiInput.value;
        }
    </script>
</body>
</html>
