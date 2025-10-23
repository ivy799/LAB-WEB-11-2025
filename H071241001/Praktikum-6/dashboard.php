<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'db_connection.php';


$summary_data = [];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];


if ($role == 'superadmin') {
    // Hitung total pengguna (kecuali superadmin)
    $sql_users = "SELECT COUNT(*) AS total_users FROM users WHERE role != 'superadmin'";
    $result_users = mysqli_query($conn, $sql_users);
    $summary_data['total_users'] = mysqli_fetch_assoc($result_users)['total_users'];

    // Hitung total proyek
    $sql_projects = "SELECT COUNT(*) AS total_projects FROM projects";
    $result_projects = mysqli_query($conn, $sql_projects);
    $summary_data['total_projects'] = mysqli_fetch_assoc($result_projects)['total_projects'];

    // Hitung total tugas
    $sql_tasks = "SELECT COUNT(*) AS total_tasks FROM tasks";
    $result_tasks = mysqli_query($conn, $sql_tasks);
    $summary_data['total_tasks'] = mysqli_fetch_assoc($result_tasks)['total_tasks'];

} elseif ($role == 'project_manager') {
   
    $sql_projects = "SELECT COUNT(*) AS my_projects FROM projects WHERE manager_id = ?";
    $stmt_projects = mysqli_prepare($conn, $sql_projects);
    mysqli_stmt_bind_param($stmt_projects, "i", $user_id);
    mysqli_stmt_execute($stmt_projects);
    $result_projects = mysqli_stmt_get_result($stmt_projects);
    $summary_data['my_projects'] = mysqli_fetch_assoc($result_projects)['my_projects'];

    
    $sql_tasks = "SELECT COUNT(t.id) AS my_tasks
                  FROM tasks t JOIN projects p ON t.project_id = p.id
                  WHERE p.manager_id = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $user_id);
    mysqli_stmt_execute($stmt_tasks);
    $result_tasks = mysqli_stmt_get_result($stmt_tasks);
    $summary_data['my_tasks'] = mysqli_fetch_assoc($result_tasks)['my_tasks'];

   
     $sql_status = "SELECT status, COUNT(*) as count
                    FROM tasks t JOIN projects p ON t.project_id = p.id
                    WHERE p.manager_id = ? GROUP BY status";
    $stmt_status = mysqli_prepare($conn, $sql_status);
    mysqli_stmt_bind_param($stmt_status, "i", $user_id);
    mysqli_stmt_execute($stmt_status);
    $result_status = mysqli_stmt_get_result($stmt_status);
    $summary_data['task_status'] = ['belum' => 0, 'proses' => 0, 'selesai' => 0]; // Default
    while ($row = mysqli_fetch_assoc($result_status)) {
        if(isset($summary_data['task_status'][$row['status']])) {
            $summary_data['task_status'][$row['status']] = $row['count'];
        }
    }

} else { // Team Member
    
    $sql_tasks = "SELECT COUNT(*) AS my_assigned_tasks FROM tasks WHERE assigned_to = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $user_id);
    mysqli_stmt_execute($stmt_tasks);
    $result_tasks = mysqli_stmt_get_result($stmt_tasks);
    $summary_data['my_assigned_tasks'] = mysqli_fetch_assoc($result_tasks)['my_assigned_tasks'];

    // Hitung status tugas
    $sql_status = "SELECT status, COUNT(*) as count FROM tasks WHERE assigned_to = ? GROUP BY status";
    $stmt_status = mysqli_prepare($conn, $sql_status);
    mysqli_stmt_bind_param($stmt_status, "i", $user_id);
    mysqli_stmt_execute($stmt_status);
    $result_status = mysqli_stmt_get_result($stmt_status);
    $summary_data['task_status'] = ['belum' => 0, 'proses' => 0, 'selesai' => 0]; // Default
    while ($row = mysqli_fetch_assoc($result_status)) {
         if(isset($summary_data['task_status'][$row['status']])) {
            $summary_data['task_status'][$row['status']] = $row['count'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white text-xl font-bold">Project Management</div>
            <div>
                <span class="text-blue-200 mr-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Your Dashboard</h2>
        <p class="text-gray-600 mb-6">Your role: <span class="font-medium bg-gray-200 px-2 py-1 rounded text-sm"><?php echo ucfirst(str_replace('_', ' ', $role)); ?></span></p>

        <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php if ($role == 'superadmin'): ?>
                    <div class="bg-white p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Total Users (Non-Admin)</div>
                        <div class="text-2xl font-bold text-gray-800"><?php echo $summary_data['total_users']; ?></div>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Total Projects</div>
                        <div class="text-2xl font-bold text-gray-800"><?php echo $summary_data['total_projects']; ?></div>
                    </div>
                     <div class="bg-white p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Total Tasks</div>
                        <div class="text-2xl font-bold text-gray-800"><?php echo $summary_data['total_tasks']; ?></div>
                    </div>
                <?php elseif ($role == 'project_manager'): ?>
                     <div class="bg-white p-4 rounded shadow">
                        <div class="text-sm text-gray-500">My Projects</div>
                        <div class="text-2xl font-bold text-blue-600"><?php echo $summary_data['my_projects']; ?></div>
                    </div>
                    <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
                        <div class="text-sm text-gray-500">Tasks in My Projects (Total: <?php echo $summary_data['my_tasks']; ?>)</div>
                        <div class="flex flex-col sm:flex-row justify-around mt-2 text-center sm:text-left">
                            <span class="text-gray-600 mb-1 sm:mb-0">Not Started: <strong class="text-red-600"><?php echo $summary_data['task_status']['belum']; ?></strong></span>
                            <span class="text-gray-600 mb-1 sm:mb-0">In Progress: <strong class="text-yellow-600"><?php echo $summary_data['task_status']['proses']; ?></strong></span>
                            <span class="text-gray-600">Completed: <strong class="text-green-600"><?php echo $summary_data['task_status']['selesai']; ?></strong></span>
                        </div>
                    </div>
                <?php else: // Team Member ?>
                    <div class="bg-white p-4 rounded shadow">
                        <div class="text-sm text-gray-500">My Assigned Tasks</div>
                        <div class="text-2xl font-bold text-purple-600"><?php echo $summary_data['my_assigned_tasks']; ?></div>
                    </div>
                     <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
                        <div class="text-sm text-gray-500">My Task Status</div>
                         <div class="flex flex-col sm:flex-row justify-around mt-2 text-center sm:text-left">
                            <span class="text-gray-600 mb-1 sm:mb-0">Not Started: <strong class="text-red-600"><?php echo $summary_data['task_status']['belum']; ?></strong></span>
                            <span class="text-gray-600 mb-1 sm:mb-0">In Progress: <strong class="text-yellow-600"><?php echo $summary_data['task_status']['proses']; ?></strong></span>
                            <span class="text-gray-600">Completed: <strong class="text-green-600"><?php echo $summary_data['task_status']['selesai']; ?></strong></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <hr class="my-6">

        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Actions</h3>
             <?php
            if ($role == 'superadmin') {
                echo "<p class='text-gray-600 mb-4'>Manage system users and view all projects.</p>";
                echo '<a href="manage_users.php" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Manage Users</a>';
                echo '<a href="admin_view_projects.php" class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">View All Projects</a>';
            } elseif ($role == 'project_manager') {
                echo "<p class='text-gray-600 mb-4'>Manage your assigned projects and their tasks.</p>";
                echo '<a href="manage_projects.php" class="inline-block bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">Manage My Projects</a>';
            } else { // Team Member
                echo "<p class='text-gray-600 mb-4'>View and update the status of tasks assigned to you.</p>";
                echo '<a href="view_tasks.php" class="inline-block bg-yellow-400 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded">View My Tasks</a>';
            }
            ?>
        </div>

    </div>

</body>
</html>