<?php
session_start();
require 'data.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$foundUser = null;
foreach ($users as $user) {
    if ($user['username'] === $username) {
        $foundUser = $user;
        break;
    }
}

if ($foundUser) {
    $password_input = $password; 
    $hashed_password = $foundUser['password']; 

    if (password_verify($password_input, $hashed_password)) {
        $_SESSION['user'] = $foundUser;
        header("Location: dashboard.php");
    } else {
        $_SESSION['error'] = "Password salah!";
        header("Location: login.php");
    }
} else {
    $_SESSION['error'] = "Username tidak ditemukan!";
    header("Location: login.php");
}
exit;
?>
