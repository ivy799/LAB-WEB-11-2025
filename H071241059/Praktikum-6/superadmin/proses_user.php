<?php
// 1. Mulai Session dan Sertakan File Penting
session_start();
include '../koneksi.php';

// 2. Cek Keamanan Dasar
// Pastikan user sudah login dan adalah superadmin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'superadmin') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// Pastikan ada parameter 'action' di URL
if (!isset($_GET['action'])) {
    header("location: kelola_user.php?error=noaction");
    exit;
}

$action = $_GET['action'];

// =================================================================
// AKSI: TAMBAH PENGGUNA (CREATE)
// =================================================================
if ($action == 'tambah') {
    
    // Pastikan metode request adalah POST (data dikirim dari form)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $username = $_POST['username'];
        $password_plain = $_POST['password']; // Password teks biasa
        $role = $_POST['role'];
        
        // 2. Hash password (SANGAT PENTING!)
        $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
        
        // 3. Validasi Password
        if (strlen($password_plain) < 5) {
             die("Error: Password minimal 5 karakter. <a href='tambah_user.php'>Kembali</a>");
        }

        // 4. Siapkan 'project_manager_id'
        // Jika rolenya 'member', ambil ID manager. Jika bukan, set ke NULL.
        $project_manager_id = NULL; // Default
        if ($role == 'member') {
            if (isset($_POST['project_manager_id']) && !empty($_POST['project_manager_id'])) {
                $project_manager_id = $_POST['project_manager_id'];
            } else {
                // Jika role 'member' tapi manager tidak dipilih
                die("Error: Role 'Team Member' wajib memilih manager. <a href='tambah_user.php'>Kembali</a>");
            }
        }
        
        // 5. Siapkan SQL (Prepared Statement)
        $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        
        if ($stmt === false) {
             die("Error persiapan query: " . $koneksi->error);
        }
        
        // 6. Bind Parameter
        // 'sssi' = String, String, String, Integer
        $stmt->bind_param("sssi", $username, $password_hash, $role, $project_manager_id);
        
<<<<<<< HEAD
        // 7. Eksekusi
        if ($stmt->execute()) {
            // Jika sukses, redirect kembali ke halaman kelola user
            header("location: kelola_user.php?status=sukses_tambah");
        } else {
            // Jika gagal (misal: username sudah ada/duplikat)

            if ($stmt->errno == 1062) {
                $error_message = urlencode("Username **'{$username}'** sudah terdaftar. Silakan gunakan username lain.");
            } else {
                // Error lain
                $error_message = urlencode("Gagal menambahkan pengguna. Error: " . $stmt->error);
            }
            
            header("location: tambah_user.php?error={$error_message}&username_gagal=" . urlencode($username));
            exit; // Tambahkan exit setelah header
        }
        
        // 8. Tutup statement
        $stmt->close();
        
=======
        try {
            if ($stmt->execute()) {
                // Jika sukses, redirect kembali ke halaman kelola user
                $stmt->close();
                header("location: kelola_user.php?status=sukses_tambah");
                exit;
            } 
            // Jika $stmt->execute() gagal dan tidak melempar exception,
            // (misalnya karena error koneksi, meskipun jarang terjadi setelah prepare),
            // kita tetap perlu penanganan:
            else {
                $error_message = urlencode("Gagal menambahkan pengguna. Error: " . $stmt->error);
                $stmt->close();
                header("location: tambah_user.php?error={$error_message}&username_gagal=" . urlencode($username));
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            // Blok ini dijalankan jika terjadi EXCEPTION (seperti Duplicate Entry)
            
            $stmt->close();
            
            // Pengecekan kode error spesifik untuk Duplikat Entri (1062)
            if ($e->getCode() == 1062) {
                $error_message = urlencode("Username '{$username}' sudah terdaftar. Silakan gunakan username lain.");
            } else {
                // Tangani error database lainnya
                $error_message = urlencode("Gagal menambahkan pengguna (DB Error): " . $e->getMessage());
            }
            
            // Redirect kembali ke halaman tambah dengan pesan error
            header("location: tambah_user.php?error={$error_message}&username_gagal=" . urlencode($username));
            exit;
        }
        
>>>>>>> 67536676be925bb573c250828c0da4aa3d3edff2
    } else {
        // Jika diakses langsung tanpa form
        header("location: tambah_user.php");
    }
}

// =================================================================
// AKSI: HAPUS PENGGUNA (DELETE)
// =================================================================
elseif ($action == 'hapus') {
    
    // 1. Ambil ID dari URL
    if (!isset($_GET['id'])) {
        header("location: kelola_user.php?error=noid");
        exit;
    }
    $id = $_GET['id'];
    
    // 2. Validasi Keamanan: JANGAN HAPUS SUPERADMIN (ID 1)
    if ($id == 1) {
        header("location: kelola_user.php?error=tidakterhapus");
        exit;
    }
    
    // 3. Siapkan SQL (Prepared Statement)
    // PENTING: Kita harus mempertimbangkan FOREIGN KEY.
    // Di database kita:
    // - project.manager_id ON DELETE RESTRICT (Mencegah manager dihapus jika punya proyek)
    // - users.project_manager_id ON DELETE SET NULL (Member yang managernya dihapus, ID managernya jadi NULL)
    // - tasks.assigned_to ON DELETE SET NULL (Tugas yang membernya dihapus, 'assigned_to' jadi NULL)
    
    // Kita coba hapus dulu
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    
    if ($stmt === false) {
         die("Error persiapan query: " . $koneksi->error);
    }
    
    // 'i' = Integer
    $stmt->bind_param("i", $id);
    
    // 4. Eksekusi
    if ($stmt->execute()) {
        // Cek apakah ada baris yang terhapus
        if ($stmt->affected_rows > 0) {
            header("location: kelola_user.php?status=sukses_hapus");
        } else {
            header("location: kelola_user.php?error=usernotfound");
        }
    } else {
        // Jika gagal (Error Foreign Key, misal: manager masih punya proyek)
        header("location: kelola_user.php?error=" . urlencode("Gagal hapus: " . $stmt->error));
    }
    
    // 5. Tutup statement
    $stmt->close();
}

// =================================================================
// AKSI: EDIT PENGGUNA (UPDATE)
// =================================================================
elseif ($action == 'edit') {
    
    // Aksi ini akan dipanggil dari form 'edit_user.php'
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $id = $_POST['id'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $password_plain = $_POST['password']; // Bisa kosong
        
        // 2. Siapkan 'project_manager_id'
        $project_manager_id = NULL;
        if ($role == 'member') {
            if (isset($_POST['project_manager_id']) && !empty($_POST['project_manager_id'])) {
                $project_manager_id = $_POST['project_manager_id'];
            } else {
                die("Error: Role 'Team Member' wajib memilih manager. <a href='edit_user.php?id=$id'>Kembali</a>");
            }
        }
        
        // 3. Cek apakah password diisi atau tidak
        if (!empty($password_plain)) {
            // --- JIKA PASSWORD DIISI (ingin di-update) ---
            
            // Validasi password
            if (strlen($password_plain) < 5) {
                 die("Error: Password baru minimal 5 karakter. <a href='edit_user.php?id=$id'>Kembali</a>");
            }
            $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
            
            // Siapkan SQL dengan update password
            $sql = "UPDATE users SET username = ?, password = ?, role = ?, project_manager_id = ? WHERE id = ?";
            $stmt = $koneksi->prepare($sql);
            // 'ssssi' = String, String, String, String (manager_id), Integer (id)
            $stmt->bind_param("ssssi", $username, $password_hash, $role, $project_manager_id, $id);
            
        } else {
            // --- JIKA PASSWORD KOSONG (tidak ingin di-update) ---
            
            // Siapkan SQL tanpa update password
            $sql = "UPDATE users SET username = ?, role = ?, project_manager_id = ? WHERE id = ?";
            $stmt = $koneksi->prepare($sql);
            // 'sssi' = String, String, String (manager_id), Integer (id)
            $stmt->bind_param("sssi", $username, $role, $project_manager_id, $id);
        }
        
        // 4. Eksekusi
        if ($stmt->execute()) {
            header("location: kelola_user.php?status=sukses_update");
        } else {
            header("location: edit_user.php?id=$id&error=" . urlencode($stmt->error));
        }
        
        // 5. Tutup statement
        $stmt->close();
        
    } else {
        header("location: kelola_user.php");
    }
}

// =================================================================
// AKSI TIDAK DIKENAL
// =================================================================
else {
    header("location: kelola_user.php?error=unknownaction");
}

// Tutup koneksi database
$koneksi->close();
?>