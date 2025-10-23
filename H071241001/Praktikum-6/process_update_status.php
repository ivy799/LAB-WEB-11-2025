<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'team_member') {
    header("Location: index.php");
    exit();
}
$team_member_id = $_SESSION['user_id'];
$task_id = $_POST['task_id'];
$new_status = $_POST['status'];
$sql_check = "SELECT id FROM tasks WHERE id = ? AND assigned_to = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $task_id, $team_member_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
if (mysqli_num_rows($result_check) == 1) {
    $sql_update = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "si", $new_status, $task_id);
    mysqli_stmt_execute($stmt_update);
}
header("Location: view_tasks.php");
exit();
?>