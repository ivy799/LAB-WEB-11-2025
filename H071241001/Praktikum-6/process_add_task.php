<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
$project_id = $_POST['project_id'];
$nama_tugas = $_POST['nama_tugas'];
$deskripsi = $_POST['deskripsi'];
$assigned_to = $_POST['assigned_to'];
$sql = "INSERT INTO tasks (project_id, nama_tugas, deskripsi, assigned_to) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "issi", $project_id, $nama_tugas, $deskripsi, $assigned_to);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: manage_tasks.php?project_id=" . $project_id);
        exit();
    } else {
        echo "Error: Failed to add task.";
    }
}
?>