<?php

// ---- Pengaturan Database ----
$db_host = 'localhost';    // Server database, biasanya 'localhost'
$db_user = 'root';         // Username database
$db_pass = '';             // Password database
$db_name = 'db_manajemen_proyek'; // Nama database Anda
// -----------------------------


// Membuat koneksi menggunakan MySQLi
$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Opsional: Mengatur character set ke utf8
// Ini bagus untuk memastikan data (termasuk emoji atau karakter spesial)
// disimpan dan diambil dengan benar.
$koneksi->set_charset("utf8");

?>