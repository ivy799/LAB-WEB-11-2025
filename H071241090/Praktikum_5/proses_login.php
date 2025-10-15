<?php
session_start();
require "data.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $found = false;
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: dashboard.php");
                exit;
            } else {
                $found = true; 
            }
        }
    }

    $_SESSION['error'] = $found ? "Password salah!" : "Username tidak ditemukan!";
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>
