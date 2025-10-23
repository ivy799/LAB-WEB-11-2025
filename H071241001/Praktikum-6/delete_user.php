<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'superadmin') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';

if (isset($_GET['id'])) {
    $user_id_to_delete = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
        mysqli_stmt_execute($stmt);
    }
}
header("Location: manage_users.php");
exit();
?>