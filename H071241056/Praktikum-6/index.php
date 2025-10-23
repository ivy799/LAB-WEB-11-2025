<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

switch ($_SESSION['role']) {
    case 'superadmin':
        header("Location: superadmin/index.php");
        break;
    case 'projectmanager':
        header("Location: manager/projects.php");
        break;
    case 'team':
        header("Location: member/tasks.php");
        break;
    default:
        header("Location: auth/login.php");
}
exit();
?>