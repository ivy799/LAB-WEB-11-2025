<?php
// 1. Sertakan file cek login & koneksi
include '../cek_login.php';
include '../koneksi.php';

// 2. Cek Role Super Admin
if ($_SESSION['role'] != 'superadmin') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session (untuk navbar)
$username_admin = $_SESSION['username'];

// 4. Cek apakah ada ID di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: kelola_user.php?error=noid");
    exit;
}

$id_user_edit = $_GET['id'];

// 5. Query untuk mengambil data user yang akan diedit
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $koneksi->prepare($sql_user);
$stmt_user->bind_param("i", $id_user_edit);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    // User tidak ditemukan
    header("location: kelola_user.php?error=usernotfound");
    exit;
}

// Ambil data user
$user_data = $result_user->fetch_assoc();
$stmt_user->close();


// 6. Query untuk mengambil daftar manager (untuk dropdown)
$sql_managers = "SELECT id, username FROM users WHERE role = 'manager' ORDER BY username";
$result_managers = $koneksi->query($sql_managers);

if (!$result_managers) {
    die("Error mengambil data manager: " . $koneksi->error);
}

// Simpan data manager ke dalam array
$managers = [];
if ($result_managers->num_rows > 0) {
    while($row = $result_managers->fetch_assoc()) {
        $managers[] = $row;
    }
}

// Koneksi bisa ditutup di sini karena semua data sudah diambil
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Super Admin</title>
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
            <a href="kelola_user.php" class="text-blue-600 hover:underline">&larr; Kembali ke Kelola Pengguna</a>
        </div>

        <h2 class="text-3xl font-bold mb-4">Edit Pengguna: <?php echo htmlspecialchars($user_data['username']); ?></h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
            
            <form action="proses_user.php?action=edit" method="POST" id="userForm">
                
                <input type="hidden" name="id" value="<?php echo $user_data['id']; ?>">

                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required
                           value="<?php echo htmlspecialchars($user_data['username']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Kosongkan jika tidak ingin diubah">
                    <p class="text-xs text-gray-500 mt-1">Isi hanya jika Anda ingin mengganti password.</p>
                </div>
                
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin" <?php echo ($user_data['role'] == 'superadmin') ? 'selected' : ''; ?>>
                            Super Admin
                        </option>
                        <option value="manager" <?php echo ($user_data['role'] == 'manager') ? 'selected' : ''; ?>>
                            Project Manager
                        </option>
                        <option value="member" <?php echo ($user_data['role'] == 'member') ? 'selected' : ''; ?>>
                            Team Member
                        </option>
                    </select>
                </div>

                <div id="manager_field" class="mb-4" style="display: none;">
                    <label for="project_manager_id" class="block text-sm font-medium text-gray-700">
                        Pilih Manager (Wajib untuk 'Member')
                    </label>
                    <select id="project_manager_id" name="project_manager_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Manager --</option>
                        
                        <?php
                        foreach ($managers as $manager) {
                            // Cek apakah manager ini adalah manager yang sedang dipilih oleh user
                            $selected = ($user_data['project_manager_id'] == $manager['id']) ? 'selected' : '';
                            echo '<option value="' . $manager['id'] . '" ' . $selected . '>';
                            echo htmlspecialchars($manager['username']);
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
                        Update Pengguna
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const managerField = document.getElementById('manager_field');
        const managerSelect = document.getElementById('project_manager_id');

        // Fungsi untuk mengecek role dan menampilkan/menyembunyikan field manager
        function toggleManagerField() {
            if (roleSelect.value === 'member') {
                managerField.style.display = 'block';
                managerSelect.setAttribute('required', 'required');
            } else {
                managerField.style.display = 'none';
                managerSelect.removeAttribute('required');
                // Jangan kosongkan nilainya, biarkan terisi jika sudah ada
            }
        }

        // 1. Jalankan fungsi saat dropdown diubah
        roleSelect.addEventListener('change', toggleManagerField);

        // 2. Jalankan fungsi saat halaman pertama kali dimuat
        // (Ini penting agar form edit langsung benar tampilannya)
        document.addEventListener('DOMContentLoaded', toggleManagerField);
    </script>

</body>
</html>