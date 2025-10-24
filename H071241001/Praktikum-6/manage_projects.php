<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';
$manager_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        input, textarea, button { display: block; width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
        <h1>Manage My Projects</h1>
        <form action="process_add_project.php" method="post">
            <h3>Create New Project</h3>
            <label for="nama_proyek">Project Name:</label>
            <input type="text" name="nama_proyek" required>
            <label for="deskripsi">Description:</label>
            <textarea name="deskripsi" rows="4"></textarea>
            <label for="tanggal_mulai">Start Date:</label>
            <input type="date" name="tanggal_mulai" required>
            <label for="tanggal_selesai">End Date:</label>
            <input type="date" name="tanggal_selesai" required>
            <button type="submit">Create Project</button>
        </form>
        <h2>Your Project List</h2>
        <table>
            <thead>
                <tr> <th>Project Name</th> <th>Start Date</th> <th>End Date</th> <th>Actions</th> </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, nama_proyek, tanggal_mulai, tanggal_selesai FROM projects WHERE manager_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $manager_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                        echo "<td>" . $row['tanggal_mulai'] . "</td>";
                        echo "<td>" . $row['tanggal_selesai'] . "</td>";
                        echo "<td>
                                <a href='edit_project.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete_project.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a> | 
                                <a href='manage_tasks.php?project_id=" . $row['id'] . "'>Manage Tasks</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>You have no projects.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>