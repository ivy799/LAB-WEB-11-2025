<?php
// Wajib ada session_start() di awal
session_start();

// Hapus semua variabel session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login
header("Location: index.php");
exit();
?>