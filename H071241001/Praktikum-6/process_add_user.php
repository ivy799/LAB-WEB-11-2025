<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'superadmin') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$project_manager_id = isset($_POST['project_manager_id']) && !empty($_POST['project_manager_id']) ? $_POST['project_manager_id'] : NULL;

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssi", $username, $hashed_password, $role, $project_manager_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: manage_users.php?status=success_add");
        exit();
    } else {
        echo "Error: Failed to add user. Username might already exist.";
    }
}
?>