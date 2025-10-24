<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$project_id = $_GET['id'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$stmt = false;

if ($role == 'superadmin') {
    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    $redirect_url = "admin_view_projects.php";
} elseif ($role == 'project_manager') {
    $sql = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $project_id, $user_id);
    $redirect_url = "manage_projects.php";
} else {
    header("Location: dashboard.php");
    exit();
}

if ($stmt) {
    mysqli_stmt_execute($stmt);
}
header("Location: " . $redirect_url);
exit();
?>