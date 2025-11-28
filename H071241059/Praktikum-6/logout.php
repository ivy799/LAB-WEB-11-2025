<?php
// Selalu mulai session di awal
session_start();

// 1. Hapus semua variabel session
$_SESSION = array();

// 2. Hancurkan session
session_destroy();

// 3. Redirect ke halaman login dengan pesan sukses logout
header("location: login.php?status=logout");
exit;
?>