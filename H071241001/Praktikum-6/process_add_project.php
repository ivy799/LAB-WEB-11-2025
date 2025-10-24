<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';
$nama_proyek = $_POST['nama_proyek'];
$deskripsi = $_POST['deskripsi'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$manager_id = $_SESSION['user_id'];
$sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: manage_projects.php?status=success_add");
        exit();
    } else {
        echo "Error: Failed to create project.";
    }
}
?>