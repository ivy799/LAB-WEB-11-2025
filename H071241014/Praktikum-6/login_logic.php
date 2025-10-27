<?php
session_start();
require "connect.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: login.php"); 
  exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

$sql = "SELECT id, username, password, role FROM users WHERE username = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt); //Menjalankan query yang sudah disiapkan
$res = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($res); //Mengubah hasil query jadi array asosiatif

$ok = false;
if ($user) {
  // Coba verifikasi bcrypt dulu
  if (password_verify($password, $user["password"])) {
    $ok = true;
  } else {
    // Kalau gagal, coba plain text
    if (hash_equals($user["password"], $password)) {
      $ok = true;
    }
  }
}

if ($ok) {
  $_SESSION["user_id"] = (int)$user["id"];
  $_SESSION["username"] = $user["username"];
  $_SESSION["role"] = $user["role"];
  session_regenerate_id(true);
  header("Location: halaman_utama.php");
  exit;
}

// Redirect ke login dengan error message
header("Location: login.php?error=1");
exit;
?>