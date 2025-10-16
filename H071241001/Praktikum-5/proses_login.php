<?php

session_start();

require_once 'data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Username dan password harus diisi!";
        header('Location: login.php');
        exit;
    }
    

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    $user_found = null;
    

    foreach ($users as $user) {
        if ($user['username'] == $username) {
            if (password_verify($password, $user['password'])) {
                $user_found = $user;
                break;
            }
        }
    }
    
    if ($user_found) {
        $_SESSION['user'] = $user_found;
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header('Location: login.php');
        exit;
    }

} else {
    header('Location: login.php');
    exit;
}
?>