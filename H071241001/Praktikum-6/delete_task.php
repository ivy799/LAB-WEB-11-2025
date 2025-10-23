<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['task_id']) || !isset($_GET['project_id'])) {
    header("Location: manage_projects.php");
    exit();
}
$task_id = $_GET['task_id'];
$project_id = $_GET['project_id'];
$manager_id = $_SESSION['user_id'];
$sql_check = "SELECT t.id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $task_id, $manager_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
if (mysqli_num_rows($result_check) == 1) {
    $sql_delete = "DELETE FROM tasks WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $task_id);
    mysqli_stmt_execute($stmt_delete);
}
header("Location: manage_tasks.php?project_id=" . $project_id);
exit();
?>