<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config/config.php");

// Hash password
$pwd_super = password_hash("superpass123", PASSWORD_DEFAULT);
$pwd_pm    = password_hash("pm123456", PASSWORD_DEFAULT);
$pwd_tm    = password_hash("team123456", PASSWORD_DEFAULT);

// Insert superadmin
mysqli_query($conn, "INSERT INTO users (username, password, role, project_manager_id)
                     VALUES ('superadmin', '$pwd_super', 'super_admin', NULL)");

// Insert project manager
mysqli_query($conn, "INSERT INTO users (username, password, role, project_manager_id)
                     VALUES ('pm_fera', '$pwd_pm', 'project_manager', NULL)");

// Ambil id dari pm_fera
$result = mysqli_query($conn, "SELECT id FROM users WHERE username='pm_fera' LIMIT 1");
$row = mysqli_fetch_assoc($result);
$pm_id = $row['id'];

// Insert team member dengan project_manager_id dari hasil query
mysqli_query($conn, "INSERT INTO users (username, password, role, project_manager_id)
                     VALUES ('tm_fera', '$pwd_tm', 'team_member', $pm_id)");

echo "Semua user berhasil ditambahkan dan password sudah di-hash!";
?>
