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
    <title>Manage Users</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        input, select, button { display: block; width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
        <h1>Manage Users</h1>
        <form action="process_add_user.php" method="post">
            <h3>Add New User</h3>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="role">Role:</label>
            <select name="role" id="role-select" required onchange="toggleManagerSelect()">
                <option value="">-- Select Role --</option>
                <option value="project_manager">Project Manager</option>
                <option value="team_member">Team Member</option>
            </select>
            <div id="manager-selection" style="display: none;">
                <label for="project_manager_id">Assign to Project Manager:</label>
                <select name="project_manager_id">
                    <option value="">-- Select Manager --</option>
                    <?php
                    $manager_sql = "SELECT id, username FROM users WHERE role = 'project_manager'";
                    $manager_result = mysqli_query($conn, $manager_sql);
                    while ($manager_row = mysqli_fetch_assoc($manager_result)) {
                        echo "<option value='" . $manager_row['id'] . "'>" . htmlspecialchars($manager_row['username']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Add User</button>
        </form>
        <h2>User List</h2>
        <table>
            <thead> <tr> <th>ID</th> <th>Username</th> <th>Role</th> <th>Action</th> </tr> </thead>
            <tbody>
                <?php
                $sql = "SELECT id, username, role FROM users WHERE role != 'superadmin'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td><a href='delete_user.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No other users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function toggleManagerSelect() {
            var roleSelect = document.getElementById('role-select');
            var managerSelectionDiv = document.getElementById('manager-selection');
            if (roleSelect.value == 'team_member') {
                managerSelectionDiv.style.display = 'block';
            } else {
                managerSelectionDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>