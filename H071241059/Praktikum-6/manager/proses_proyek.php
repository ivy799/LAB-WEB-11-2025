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
// AKSI: TAMBAH PROYEK (CREATE)
// =================================================================
if ($action == 'tambah') {
    
    // Pastikan metode request adalah POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $nama_proyek = $_POST['nama_proyek'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        
        // 2. Ambil manager_id dari input hidden (yang sudah diisi dari session)
        // Ini sebagai validasi tambahan
        $form_manager_id = $_POST['manager_id'];
        
        // 3. Validasi Keamanan: Pastikan ID di form = ID di session
        if ($form_manager_id != $manager_id) {
            die("Error: Terjadi konflik data manager. Aksi dibatalkan.");
        }
        
        // 4. Siapkan SQL (Prepared Statement)
        $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $koneksi->prepare($sql);
        
        if ($stmt === false) {
             die("Error persiapan query: ". $koneksi->error);
        }
        
        // 5. Bind Parameter
        // 'ssssi' = String, String, String, String, Integer
        $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);
        
        // 6. Eksekusi
        if ($stmt->execute()) {
            // Jika sukses, redirect kembali ke halaman proyek
            header("location: proyek_saya.php?status=sukses_tambah");
        } else {
            // Jika gagal
            header("location: tambah_proyek.php?error=" . urlencode($stmt->error));
        }
        
        // 7. Tutup statement
        $stmt->close();
        
    } else {
        header("location: tambah_proyek.php");
    }
}

// =================================================================
// AKSI: HAPUS PROYEK (DELETE)
// =================================================================
elseif ($action == 'hapus') {
    
    // 1. Ambil ID Proyek dari URL
    if (!isset($_GET['id'])) {
        header("location: proyek_saya.php?error=noid");
        exit;
    }
    $project_id = $_GET['id'];
    
    // 2. Siapkan SQL (Prepared Statement)
    // PENTING (Keamanan): 
    // Kita tambahkan 'AND manager_id = ?'
    // Ini memastikan seorang manager HANYA bisa menghapus proyek miliknya sendiri.
    $sql = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
    $stmt = $koneksi->prepare($sql);
    
    if ($stmt === false) {
         die("Error persiapan query: " . $koneksi->error);
    }
    
    // 'ii' = Integer (project_id), Integer (manager_id)
    $stmt->bind_param("ii", $project_id, $manager_id);
    
    // 4. Eksekusi
    if ($stmt->execute()) {
        // Cek apakah ada baris yang terhapus
        if ($stmt->affected_rows > 0) {
            // Sukses. (Tugas di dalamnya otomatis terhapus karena ON DELETE CASCADE)
            header("location: proyek_saya.php?status=sukses_hapus");
        } else {
            // Gagal, kemungkinan karena project_id tidak ditemukan
            // ATAU project_id itu bukan milik manager ini (affected_rows = 0)
            header("location: proyek_saya.php?status=gagal_hapus&error=aksesditolak");
        }
    } else {
        // Gagal karena error SQL lain
        header("location: proyek_saya.php?status=gagal_hapus&error=" . urlencode($stmt->error));
    }
    
    // 5. Tutup statement
    $stmt->close();
}

// =================================================================
// AKSI: EDIT PROYEK (UPDATE)
// =================================================================
elseif ($action == 'edit') {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Ambil data dari form
        $project_id = $_POST['id']; // ID Proyek dari hidden input
        $nama_proyek = $_POST['nama_proyek'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        
        // 2. Siapkan SQL (Prepared Statement)
        // PENTING (Keamanan):
        // Kita tambahkan 'WHERE id = ? AND manager_id = ?'
        // Ini memastikan seorang manager HANYA bisa mengedit proyek miliknya sendiri.
        $sql = "UPDATE projects SET 
                    nama_proyek = ?, 
                    deskripsi = ?, 
                    tanggal_mulai = ?, 
                    tanggal_selesai = ? 
                WHERE 
                    id = ? AND manager_id = ?";
                    
        $stmt = $koneksi->prepare($sql);
        
        if ($stmt === false) {
             die("Error persiapan query: " . $koneksi->error);
        }
        
        // 3. Bind Parameter
        // 'ssssii' = String, String, String, String, Integer (id), Integer (manager_id)
        $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);
        
        // 4. Eksekusi
        if ($stmt->execute()) {
            // Cek apakah ada baris yang ter-update
            if ($stmt->affected_rows > 0) {
                header("location: proyek_saya.php?status=sukses_update");
            } else {
                // Tidak ada yang ter-update (mungkin ID-nya salah atau bukan milik dia)
                header("location: proyek_saya.php?status=gagal_update&error=tidakada_perubahan");
            }
        } else {
            // Gagal karena error SQL
            header("location: edit_proyek.php?id=$project_id&error=" . urlencode($stmt->error));
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