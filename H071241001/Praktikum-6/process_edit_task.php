<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
$task_id = $_POST['task_id'];
$project_id = $_POST['project_id'];
$nama_tugas = $_POST['nama_tugas'];
$deskripsi = $_POST['deskripsi'];
$status = $_POST['status'];
$assigned_to = $_POST['assigned_to'];
$manager_id = $_SESSION['user_id'];
$sql_check = "SELECT t.id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $task_id, $manager_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
if (mysqli_num_rows($result_check) == 1) {
    $sql_update = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, status = ?, assigned_to = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sssii", $nama_tugas, $deskripsi, $status, $assigned_to, $task_id);
    mysqli_stmt_execute($stmt_update);
}
header("Location: manage_tasks.php?project_id=" . $project_id);
exit();
?>