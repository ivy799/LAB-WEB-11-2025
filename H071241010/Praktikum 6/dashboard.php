<?php
include 'config.php';     
include 'includes/header.php'; 

// Cek role user dari session
$role = $_SESSION['role'];

switch ($role) {
    case 'Super Admin':
        include 'partials/superadmin_dashboard.php';
        break;
    case 'Project Manager':
        include 'partials/pm_dashboard.php';
        break;
    case 'Team Member':
        include 'partials/member_dashboard.php';
        break;
    default:
        echo '<div class="alert alert-danger">Error: Role pengguna tidak dikenali.</div>';
        break;
}

include 'includes/footer.php'; 
?>