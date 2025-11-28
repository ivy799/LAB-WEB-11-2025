<?php
// 1. Mulai Session dan Sertakan File Penting
session_start();
include '../koneksi.php';

// 2. Cek Keamanan Dasar
// Pastikan user sudah login dan adalah member
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'member') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil ID member dari session
$member_id = $_SESSION['user_id'];

// 4. Pastikan metode request adalah POST (data dikirim dari form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 5. Ambil data dari form di 'tugas_saya.php'
    if (!isset($_POST['task_id']) || !isset($_POST['new_status'])) {
        header("location: tugas_saya.php?error=invaliddata");
        exit;
    }
    
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];
    
    // Validasi status (opsional tapi bagus)
    $valid_statuses = ['belum', 'dikerjakan', 'selesai'];
    if (!in_array($new_status, $valid_statuses)) {
        header("location: tugas_saya.php?error=invalidstatus");
        exit;
    }
    
    // 6. Siapkan SQL (Prepared Statement) dengan Validasi Keamanan
    //
    // PENTING:
    // 'WHERE id = ?' -> Memastikan kita update tugas yang benar.
    // 'AND assigned_to = ?' -> Memastikan TUGAS ITU MILIK MEMBER INI.
    //
    // Ini mencegah member (ID 5) mengubah status tugas milik member (ID 4)
    //
    $sql = "UPDATE tasks 
            SET status = ? 
            WHERE id = ? AND assigned_to = ?";
            
    $stmt = $koneksi->prepare($sql);
    
    if ($stmt === false) {
         die("Error persiapan query: " . $koneksi->error);
    }
    
    // 7. Bind Parameter
    // 'sii' = String (status), Integer (id), Integer (assigned_to)
    $stmt->bind_param("sii", $new_status, $task_id, $member_id);
    
    // 8. Eksekusi
    if ($stmt->execute()) {
        // Jika sukses (baik ada perubahan atau tidak),
        // redirect kembali ke halaman tugas saya
        header("location: tugas_saya.php?status=sukses_update");
    } else {
        // Jika ada error SQL
        header("location: tugas_saya.php?error=" . urlencode($stmt->error));
    }
    
    // 9. Tutup statement
    $stmt->close();

} else {
    // Jika file diakses langsung tanpa POST
    header("location: tugas_saya.php");
}

// 10. Tutup koneksi
$koneksi->close();
?>