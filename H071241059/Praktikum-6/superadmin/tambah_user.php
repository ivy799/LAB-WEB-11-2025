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
$username = $_SESSION['username'];

// 4. Query untuk mengambil daftar manager
// Data ini kita perlukan untuk mengisi dropdown 'Pilih Manager'
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

// Kita tutup koneksi di sini karena query sudah selesai
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Super Admin</title>
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
        
        <div class="mb-6">
            <a href="kelola_user.php" class="text-blue-600 hover:underline">&larr; Kembali ke Kelola Pengguna</a>
        </div>

        <h2 class="text-3xl font-bold mb-4">Tambah Pengguna Baru</h2>

<<<<<<< HEAD
=======
        <?php
        if (isset($_GET['error'])) {
            $error_msg = htmlspecialchars(urldecode($_GET['error']));
            echo '<div class="mb-4 p-3 bg-red-100 border w-fit border-red-400 text-red-700 rounded-md text-sm">';
            echo '<strong>Gagal!</strong> ' . $error_msg;            
            echo '</div>';
        }
        ?>

>>>>>>> 67536676be925bb573c250828c0da4aa3d3edff2
        <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
            
            <form action="proses_user.php?action=tambah" method="POST" id="userForm">
                
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Min. 5 karakter">
                </div>
                
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="manager">Project Manager</option>
                        <option value="member">Team Member</option>
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
                        // Loop data manager yang sudah kita ambil dari database
                        foreach ($managers as $manager) {
                            echo '<option value="' . $manager['id'] . '">' . htmlspecialchars($manager['username']) . '</option>';
                        }
                        ?>
                        
                        <?php if (empty($managers)) : ?>
                            <option value="" disabled>Tidak ada manager tersedia</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                   text-white bg-green-600 hover:bg-green-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Pengguna
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Ambil elemen 'role' dan 'manager_field'
        const roleSelect = document.getElementById('role');
        const managerField = document.getElementById('manager_field');
        const managerSelect = document.getElementById('project_manager_id');

        // Tambahkan event listener 'change' pada dropdown role
        roleSelect.addEventListener('change', function() {
            // Jika nilai yang dipilih adalah 'member'
            if (this.value === 'member') {
                // Tampilkan field manager
                managerField.style.display = 'block';
                // Jadikan dropdown manager 'required' (wajib diisi)
                managerSelect.setAttribute('required', 'required');
            } else {
                // Jika bukan 'member', sembunyikan field manager
                managerField.style.display = 'none';
                // Hapus atribut 'required'
                managerSelect.removeAttribute('required');
                // Kosongkan nilainya
                managerSelect.value = '';
            }
        });
    </script>

</body>
</html>