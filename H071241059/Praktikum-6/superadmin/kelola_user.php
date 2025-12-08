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
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// 4. Query untuk mengambil semua data user
// Kita menggunakan LEFT JOIN ke tabel users itu sendiri (self-join)
// 'u1' adalah user yang sedang kita lihat
// 'u2' adalah manager dari user 'u1'
// Ini agar kita bisa menampilkan 'username' managernya, bukan cuma 'project_manager_id'
$sql = "SELECT 
            u1.id, 
            u1.username, 
            u1.role, 
            u1.project_manager_id, 
            u2.username AS manager_name 
        FROM 
            users u1 
        LEFT JOIN 
            users u2 ON u1.project_manager_id = u2.id
        ORDER BY 
            u1.role, u1.username";

$result = $koneksi->query($sql);

if (!$result) {
    die("Error mengambil data user: " . $koneksi->error);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Super Admin</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        
        <div class="flex justify-between items-center mb-6">
            <a href="dashboard.php" class="text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            <a href="tambah_user.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-sm">
                + Tambah Pengguna Baru
            </a>
        </div>

        <h2 class="text-3xl font-bold mb-4">Kelola Pengguna Sistem</h2>

        <?php
        // ----------------------------------------------------------------
        // TAMBAHKAN BLOK INI UNTUK MENAMPILKAN ERROR
        // ----------------------------------------------------------------
        if (isset($_GET['error'])) {
            $error_msg = htmlspecialchars(urldecode($_GET['error']));
            echo '<div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">';
            echo '<strong>Gagal!</strong> ' . $error_msg;
            
            // Tambahkan tombol untuk membersihkan pesan error (Opsional, tapi bagus)
            echo ' <a href="kelola_user.php" class="text-red-700 font-bold hover:text-red-900 ml-2">[X]</a>';
            echo '</div>';
        }
        // ----------------------------------------------------------------
        ?>
        
        <?php
        if (isset($_GET['status'])) {
            $status_msg = '';
            if ($_GET['status'] == 'sukses_tambah') {
                $status_msg = 'Pengguna baru berhasil ditambahkan.';
            } elseif ($_GET['status'] == 'sukses_update') {
                $status_msg = 'Data pengguna berhasil diperbarui.';
            } elseif ($_GET['status'] == 'sukses_hapus') {
                $status_msg = 'Data pengguna berhasil dihapus.';
            }
            
            if ($status_msg) {
                echo '<div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">';
                echo htmlspecialchars($status_msg);
                echo '</div>';
            }
        }
        ?>

        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manager (jika member)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if ($result->num_rows > 0) {
                        // Loop data
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $no; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php 
                            $role_badge = '';
                            if ($row['role'] == 'superadmin') {
                                $role_badge = 'bg-blue-100 text-blue-800';
                            } elseif ($row['role'] == 'manager') {
                                $role_badge = 'bg-green-100 text-green-800';
                            } else {
                                $role_badge = 'bg-gray-100 text-gray-800';
                            }
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $role_badge; ?>">
                                <?php echo htmlspecialchars($row['role']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php 
                            // Tampilkan nama manager jika ada, jika tidak tampilkan '-'
                            echo $row['manager_name'] ? htmlspecialchars($row['manager_name']) : '-'; 
                            ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            
                            <?php if ($row['id'] != 1) : // Mencegah superadmin (ID 1) dihapus ?>
                                <a href="proses_user.php?action=hapus&id=<?php echo $row['id']; ?>" 
                                   class="text-red-600 hover:text-red-900"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user <?php echo htmlspecialchars($row['username']); ?>?');">
                                   Hapus
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    $no++; 
                        }
                    } else {
                        // Jika tidak ada data
                        echo '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengguna.</td></tr>';
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