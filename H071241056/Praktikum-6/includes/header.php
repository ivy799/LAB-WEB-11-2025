<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <h5 class="text-white px-3">Menu</h5>
                    <ul class="nav flex-column">
                        <?php if ($_SESSION['role'] == 'superadmin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../superadmin/manage_users.php">
                                    <i class="fas fa-users"></i> Kelola Pengguna
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../superadmin/manage_projects.php">
                                    <i class="fas fa-project-diagram"></i> Kelola Proyek
                                </a>
                            </li>
                        <?php elseif ($_SESSION['role'] == 'projectmanager'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../manager/projects.php">
                                    <i class="fas fa-project-diagram"></i> Proyek Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../manager/tasks.php">
                                    <i class="fas fa-tasks"></i> Tugas
                                </a>
                            </li>
                        <?php elseif ($_SESSION['role'] == 'team'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../member/tasks.php">
                                    <i class="fas fa-tasks"></i> Tugas Saya
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand">Project Management System</span>
                        <div class="navbar-nav ms-auto">
                            <span class="navbar-text">
                                Halo, <?php echo $_SESSION['username']; ?> 
                                (<?php echo ucfirst($_SESSION['role']); ?>)
                            </span>
                        </div>
                    </div>
                </nav>