<?php
include 'config.php'; 

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    header("Location: index.php?error=Username dan Password wajib diisi");
    exit();
}

$stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    } else {
        exit();
    }
} else {
    header("Location: index.php?error=Username tidak ditemukan");
    exit();
}

$stmt->close();
$koneksi->close();
?>