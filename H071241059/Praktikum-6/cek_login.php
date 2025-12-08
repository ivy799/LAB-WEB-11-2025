<?php
// Memulai session jika belum ada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user BELUM login
// Periksa apakah session 'loggedin' tidak ada ATAU tidak bernilai true
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    
    // Jika belum login, redirect (arahkan) pengguna kembali ke halaman login.
    // Kita tambahkan parameter error=sesihabis
    // Path '../login.php' digunakan karena file ini akan di-include
    // dari file yang berada di dalam sub-folder (e.g., 'superadmin/dashboard.php')
    
    header("location: ../login.php?error=sesihabis");
    exit; // Pastikan skrip berhenti setelah redirect
}
?>