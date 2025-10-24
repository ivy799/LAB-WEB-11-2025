<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['project_id'])) {
    header("Location: manage_projects.php");
    exit();
}
$project_id = $_GET['project_id'];
$manager_id = $_SESSION['user_id'];
$sql_project = "SELECT nama_proyek FROM projects WHERE id = ? AND manager_id = ?";
$stmt_project = mysqli_prepare($conn, $sql_project);
mysqli_stmt_bind_param($stmt_project, "ii", $project_id, $manager_id);
mysqli_stmt_execute($stmt_project);
$result_project = mysqli_stmt_get_result($stmt_project);
if (mysqli_num_rows($result_project) == 0) {
    header("Location: manage_projects.php");
    exit();
}
$project = mysqli_fetch_assoc($result_project);
$nama_proyek = $project['nama_proyek'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tasks - <?php echo htmlspecialchars($nama_proyek); ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        input, select, textarea, button { display: block; width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="manage_projects.php" class="back-link">&larr; Back to Projects</a>
        <h1>Tasks for Project: "<?php echo htmlspecialchars($nama_proyek); ?>"</h1>
        <form action="process_add_task.php" method="post">
            <h3>Add New Task</h3>
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            <label for="nama_tugas">Task Name:</label>
            <input type="text" name="nama_tugas" required>
            <label for="deskripsi">Description:</label>
            <textarea name="deskripsi" rows="3"></textarea>
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
                    echo "<option value='" . $member['id'] . "'>" . htmlspecialchars($member['username']) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Add Task</button>
        </form>
        <h2>Task List</h2>
        <table>
            <thead>
                <tr> <th>Task Name</th> <th>Assigned To</th> <th>Status</th> <th>Actions</th> </tr>
            </thead>
            <tbody>
                <?php
                $sql_tasks = "SELECT t.id, t.nama_tugas, t.status, u.username FROM tasks t JOIN users u ON t.assigned_to = u.id WHERE t.project_id = ?";
                $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
                mysqli_stmt_bind_param($stmt_tasks, "i", $project_id);
                mysqli_stmt_execute($stmt_tasks);
                $result_tasks = mysqli_stmt_get_result($stmt_tasks);
                if (mysqli_num_rows($result_tasks) > 0) {
                    while ($task = mysqli_fetch_assoc($result_tasks)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($task['nama_tugas']) . "</td>";
                        echo "<td>" . htmlspecialchars($task['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($task['status']) . "</td>";
                        echo "<td>
                                <a href='edit_task.php?task_id=" . $task['id'] . "'>Edit</a> | 
                                <a href='delete_task.php?task_id=" . $task['id'] . "&project_id=" . $project_id . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No tasks found for this project.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>