<?php
// 1. Mulai Session dan Sertakan File Penting
session_start();
include '../koneksi.php';

// 2. Cek Keamanan Dasar
// Pastikan user sudah login dan adalah manager
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// Ambil ID manager dari session
$manager_id = $_SESSION['user_id'];

// Pastikan ada parameter 'action' di URL
if (!isset($_GET['action'])) {
    header("location: proyek_saya.php?error=noaction");
    exit;
}

$action = $_GET['action'];

// =================================================================
// AKSI: TAMBAH TUGAS (CREATE)
// =================================================================
if ($action == 'tambah') {
    
    // Pastikan metode request adalah POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $project_id = $_POST['project_id'];
        $nama_tugas = $_POST['nama_tugas'];
        $deskripsi = $_POST['deskripsi'];
        
        // Cek 'assigned_to', jika kosong set ke NULL
        $assigned_to = NULL; // Default
        if (isset($_POST['assigned_to']) && !empty($_POST['assigned_to'])) {
            $assigned_to = $_POST['assigned_to'];
        }
        
        // 2. Validasi Keamanan: 
        // Cek apakah proyek (project_id) ini benar-benar milik manager yang login
        $sql_check = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
        $stmt_check = $koneksi->prepare($sql_check);
        $stmt_check->bind_param("ii", $project_id, $manager_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows == 0) {
            // Jika tidak, HENTIKAN. Ini percobaan akses ilegal.
            die("Error: Anda tidak memiliki hak akses untuk menambah tugas ke proyek ini.");
        }
        $stmt_check->close();
        
        // 3. Siapkan SQL (Prepared Statement) untuk INSERT
        // Status otomatis 'belum' (sesuai default database)
        $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $koneksi->prepare($sql);
        
        if ($stmt === false) {
             die("Error persiapan query: ". $koneksi->error);
        }
        
        // 4. Bind Parameter
        // 'ssii' = String, String, Integer, Integer (assigned_to bisa NULL)
        $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
        
        // 5. Eksekusi
        if ($stmt->execute()) {
            // Jika sukses, redirect kembali ke halaman kelola tugas
            header("location: kelola_tugas.php?project_id=$project_id&status=sukses_tambah");
        } else {
            // Jika gagal
            header("location: kelola_tugas.php?project_id=$project_id&error=" . urlencode($stmt->error));
        }
        
        // 6. Tutup statement
        $stmt->close();
        
    } else {
        header("location: proyek_saya.php");
    }
}

// =================================================================
// AKSI: HAPUS TUGAS (DELETE)
// =================================================================
elseif ($action == 'hapus') {
    
    // 1. Ambil ID Tugas & ID Proyek (untuk redirect)
    if (!isset($_GET['id']) || !isset($_GET['project_id'])) {
        header("location: proyek_saya.php?error=noid");
        exit;
    }
    $task_id = $_GET['id'];
    $project_id = $_GET['project_id']; // Hanya untuk redirect
    
    // 2. Siapkan SQL (Prepared Statement) dengan Validasi Keamanan
    // Kita DELETE 't' (tasks) dengan JOIN ke 'p' (projects)
    // dan cek 'p.manager_id'
    // Ini memastikan manager hanya bisa hapus tugas dari proyek miliknya
    $sql = "DELETE t FROM tasks t 
            JOIN projects p ON t.project_id = p.id 
            WHERE t.id = ? AND p.manager_id = ?";
            
    $stmt = $koneksi->prepare($sql);
    
    if ($stmt === false) {
         die("Error persiapan query: " . $koneksi->error);
    }
    
    // 'ii' = Integer (task_id), Integer (manager_id)
    $stmt->bind_param("ii", $task_id, $manager_id);
    
    // 3. Eksekusi
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("location: kelola_tugas.php?project_id=$project_id&status=sukses_hapus");
        } else {
            // Gagal (tugas tidak ditemukan ATAU bukan miliknya)
            header("location: kelola_tugas.php?project_id=$project_id&error=hapusgagal");
        }
    } else {
        header("location: kelola_tugas.php?project_id=$project_id&error=" . urlencode($stmt->error));
    }
    
    // 4. Tutup statement
    $stmt->close();
}

// =================================================================
// AKSI: EDIT TUGAS (UPDATE)
// =================================================================
elseif ($action == 'edit') {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $task_id = $_POST['id'];
        $project_id = $_POST['project_id']; // Untuk redirect
        $nama_tugas = $_POST['nama_tugas'];
        $deskripsi = $_POST['deskripsi'];
        $status = $_POST['status'];
        
        // Cek 'assigned_to', jika kosong set ke NULL
        $assigned_to = NULL;
        if (isset($_POST['assigned_to']) && !empty($_POST['assigned_to'])) {
            $assigned_to = $_POST['assigned_to'];
        }

        // 2. Siapkan SQL (Prepared Statement) dengan Validasi Keamanan
        // Kita UPDATE 't' (tasks) dengan JOIN ke 'p' (projects)
        // dan cek 'p.manager_id'
        $sql = "UPDATE tasks t
                JOIN projects p ON t.project_id = p.id
                SET 
                    t.nama_tugas = ?, 
                    t.deskripsi = ?, 
                    t.status = ?, 
                    t.assigned_to = ?
                WHERE 
                    t.id = ? AND p.manager_id = ?";
                    
        $stmt = $koneksi->prepare($sql);
        
        if ($stmt === false) {
             die("Error persiapan query: " . $koneksi->error);
        }
        
        // 3. Bind Parameter
        // 'sssiii' = String, String, String, Integer (bisa null), Integer (id), Integer (manager_id)
        $stmt->bind_param("sssiii", $nama_tugas, $deskripsi, $status, $assigned_to, $task_id, $manager_id);
        
        // 4. Eksekusi
        if ($stmt->execute()) {
            // affected_rows > 0 berarti ada perubahan
            // affected_rows == 0 berarti tidak ada perubahan (data sama) atau ID salah/bukan miliknya
            header("location: kelola_tugas.php?project_id=$project_id&status=sukses_update");
        } else {
            header("location: edit_tugas.php?id=$task_id&error=" . urlencode($stmt->error));
        }
        
        // 5. Tutup statement
        $stmt->close();
        
    } else {
        header("location: proyek_saya.php");
    }
}

// =================================================================
// AKSI TIDAK DIKENAL
// =================================================================
else {
    header("location: proyek_saya.php?error=unknownaction");
}

// Tutup koneksi database
$koneksi->close();
?>