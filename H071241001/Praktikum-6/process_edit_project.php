<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
$manager_id = $_SESSION['user_id'];
$project_id = $_POST['project_id'];
$nama_proyek = $_POST['nama_proyek'];
$deskripsi = $_POST['deskripsi'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];

$sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);
mysqli_stmt_execute($stmt);

header("Location: manage_projects.php");
exit();
?>