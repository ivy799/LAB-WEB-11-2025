<?php

// Sertakan file koneksi
include 'koneksi.php';

echo "<h1>Proses Update Password...</h1>";

// Password '12345' yang akan kita hash
$password_plain = '12345';

// Hasilkan hash yang aman
// PASSWORD_DEFAULT adalah algoritma terkuat yang tersedia di PHP (saat ini BCRYPT)
$hash_aman = password_hash($password_plain, PASSWORD_DEFAULT);

if (!$hash_aman) {
    die("Gagal membuat hash. Pastikan versi PHP Anda kompatibel.");
}

echo "<p>Password asli: " . htmlspecialchars($password_plain) . "</p>";
echo "<p>Hash yang Dihasilkan: " . htmlspecialchars($hash_aman) . "</p>";

// Siapkan query untuk update SEMUA user yang passwordnya '12345'
// (Ini hanya aman untuk data contoh kita)
$sql = "UPDATE users SET password = ? WHERE password = ?";

// Gunakan prepared statement untuk keamanan
$stmt = $koneksi->prepare($sql);
if ($stmt === false) {
    die("Gagal mempersiapkan statement: " . $koneksi->error);
}

// 'ss' berarti kita binding dua parameter string (String, String)
$stmt->bind_param('ss', $hash_aman, $password_plain);

// Eksekusi
if ($stmt->execute()) {
    $jumlah_terpengaruh = $stmt->affected_rows;
    echo "<h2>Sukses!</h2>";
    echo "<p>Berhasil meng-update " . $jumlah_terpengaruh . " baris di database.</p>";
    echo "<p>Password pengguna Anda sekarang sudah aman (di-hash).</p>";
} else {
    echo "<h2>Gagal!</h2>";
    echo "<p>Error saat eksekusi update: " . $stmt->error . "</p>";
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();

echo "<br><a href='login.php'>Kembali ke Halaman Login</a>";

?>