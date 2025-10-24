<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'superadmin') {
    header("Location: index.php");
    exit();
}
require 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Projects</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
        <h1>View All Projects</h1>
        <table>
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Project Manager</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id, p.nama_proyek, p.tanggal_mulai, p.tanggal_selesai, u.username AS manager_name 
                        FROM projects p 
                        JOIN users u ON p.manager_id = u.id
                        ORDER BY p.id DESC";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['manager_name']) . "</td>";
                        echo "<td>" . $row['tanggal_mulai'] . "</td>";
                        echo "<td>" . $row['tanggal_selesai'] . "</td>";
                        echo "<td><a href='delete_project.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No projects found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>