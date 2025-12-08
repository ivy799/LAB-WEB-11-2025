<?php

// --- 1. KONEKSI DATABASE ---
// (Sesuaikan dengan konfigurasi Anda jika berbeda)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_manajemen_proyek'; // Sesuaikan nama database jika perlu

$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
// ---------------------------

echo "<h3>Proses Reset Password Massal</h3>";

// 2. Tentukan password baru
$password_plain = "password";

// 3. Buat Hash Password
// PASSWORD_DEFAULT menggunakan algoritma Bcrypt (saat ini) yang aman
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

echo "<p>Password asli: <strong>" . htmlspecialchars($password_plain) . "</strong></p>";
echo "<p>Hash baru: " . htmlspecialchars($password_hash) . "</p>";

// 4. Query Update
// Query ini akan mengubah kolom password untuk SEMUA baris di tabel users
$sql = "UPDATE users SET password = ?";

$stmt = $koneksi->prepare($sql);

if ($stmt) {
    // Bind parameter (s = string)
    $stmt->bind_param("s", $password_hash);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<h2 style='color: green;'>Sukses!</h2>";
        echo "<p>Berhasil mengubah data. " . $stmt->affected_rows . " user kini memiliki password 'password'.</p>";
    } else {
        echo "<h2 style='color: red;'>Gagal Eksekusi!</h2>";
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<h2 style='color: red;'>Gagal Prepare Statement!</h2>";
    echo "<p>Error: " . $koneksi->error . "</p>";
}

$koneksi->close();
?>