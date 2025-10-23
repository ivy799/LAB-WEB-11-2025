<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['task_id'])) {
    header("Location: manage_projects.php");
    exit();
}
$task_id = $_GET['task_id'];
$manager_id = $_SESSION['user_id'];
$sql_task = "SELECT t.* FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?";
$stmt_task = mysqli_prepare($conn, $sql_task);
mysqli_stmt_bind_param($stmt_task, "ii", $task_id, $manager_id);
mysqli_stmt_execute($stmt_task);
$result_task = mysqli_stmt_get_result($stmt_task);
if (mysqli_num_rows($result_task) == 0) {
    header("Location: manage_projects.php");
    exit();
}
$task = mysqli_fetch_assoc($result_task);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
        input, select, textarea, button { display: block; width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="manage_tasks.php?project_id=<?php echo $task['project_id']; ?>" class="back-link">&larr; Back to Tasks</a>
        <h1>Edit Task: <?php echo htmlspecialchars($task['nama_tugas']); ?></h1>
        <form action="process_edit_task.php" method="post">
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
            <input type="hidden" name="project_id" value="<?php echo $task['project_id']; ?>">
            <label for="nama_tugas">Task Name:</label>
            <input type="text" name="nama_tugas" value="<?php echo htmlspecialchars($task['nama_tugas']); ?>" required>
            <label for="deskripsi">Description:</label>
            <textarea name="deskripsi" rows="3"><?php echo htmlspecialchars($task['deskripsi']); ?></textarea>
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="belum" <?php echo ($task['status'] == 'belum') ? 'selected' : ''; ?>>Not Started</option>
                <option value="proses" <?php echo ($task['status'] == 'proses') ? 'selected' : ''; ?>>In Progress</option>
                <option value="selesai" <?php echo ($task['status'] == 'selesai') ? 'selected' : ''; ?>>Completed</option>
            </select>
            <label for="assigned_to">Assign to:</label>
            <select name="assigned_to" required>
                <option value="">-- Select Team Member --</option>
                <?php
                $sql_members = "SELECT id, username FROM users WHERE role = 'team_member' AND project_manager_id = ?";
                $stmt_members = mysqli_prepare($conn, $sql_members);
                mysqli_stmt_bind_param($stmt_members, "i", $manager_id);
                mysqli_stmt_execute($stmt_members);
                $result_members = mysqli_stmt_get_result($stmt_members);
                while($member = mysqli_fetch_assoc($result_members)) {
                    $selected = ($member['id'] == $task['assigned_to']) ? 'selected' : '';
                    echo "<option value='" . $member['id'] . "' $selected>" . htmlspecialchars($member['username']) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>