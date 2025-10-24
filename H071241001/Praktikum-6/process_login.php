<?php
session_start();
require 'db_connection.php'; 

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
}
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, username, password, role FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        }
    }
}
header("Location: index.php?error=failed");
exit();
?>