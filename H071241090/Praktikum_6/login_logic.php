<?php 
session_start();
include("config/config.php");

$username = $_POST['username'];
$password = $_POST['password'];

// cek user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result(($stmt));
$user = mysqli_fetch_assoc(($result));

if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'super_admin') {
            header("Location: dashboard_admin.php");
        } elseif ($user['role'] === 'project_manager') {
            header("Location: dashboard_pm.php");
        } else {
            header("Location: dashboard_tm.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Password salah!";
    }
} else {
    $_SESSION['error'] = "Username tidak ditemukan!";
}

header("Location: login.php");
exit;


?>