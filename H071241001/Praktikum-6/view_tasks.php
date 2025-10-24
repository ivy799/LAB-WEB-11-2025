<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'team_member') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';
$team_member_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .project-card { border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .task-list { list-style-type: none; padding-left: 0; }
        .task-list li { padding: 10px; border-bottom: 1px solid #eee; }
        .task-list li:last-child { border-bottom: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
        .status-form { display: inline; }
        .status-select { padding: 4px; }
        .status-btn { padding: 4px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
        <h1>My Task List</h1>
        <?php
        $sql = "SELECT p.nama_proyek, t.id AS task_id, t.nama_tugas, t.deskripsi, t.status FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.assigned_to = ? ORDER BY p.nama_proyek ASC, t.id ASC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $team_member_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $current_project = "";
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['nama_proyek'] != $current_project) {
                    if ($current_project != "") {
                        echo "</ul></div>";
                    }
                    $current_project = $row['nama_proyek'];
                    echo "<div class='project-card'>";
                    echo "<h2>Project: " . htmlspecialchars($current_project) . "</h2>";
                    echo "<ul class='task-list'>";
                }
                echo "<li>";
                echo "<strong>" . htmlspecialchars($row['nama_tugas']) . "</strong>";
                echo "<p>" . htmlspecialchars($row['deskripsi']) . "</p>";
                echo "<form action='process_update_status.php' method='post' class='status-form'>";
                echo "<input type='hidden' name='task_id' value='" . $row['task_id'] . "'>";
                echo "<span>Status: </span>";
                echo "<select name='status' class='status-select'>";
                echo "<option value='belum'" . ($row['status'] == 'belum' ? ' selected' : '') . ">Not Started</option>";
                echo "<option value='proses'" . ($row['status'] == 'proses' ? ' selected' : '') . ">In Progress</option>";
                echo "<option value='selesai'" . ($row['status'] == 'selesai' ? ' selected' : '') . ">Completed</option>";
                echo "</select>";
                echo "<button type='submit' class='status-btn'>Update</button>";
                echo "</form>";
                echo "</li>";
            }
            echo "</ul></div>";
        } else {
            echo "<div class='project-card'><p>You have not been assigned any tasks.</p></div>";
        }
        ?>
    </div>
</body>
</html> 