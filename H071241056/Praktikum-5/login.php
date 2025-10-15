<?php 
session_start();

require 'data.php';

if (isset($_SESSION["user"])){
    header("Location: dashboard.php");
    exit();
    }

$error = "";
if (isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h2>Login System</h2>
        <?php if($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label>Username: </label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password: </label>
                <input type="password" name="password" required>
            </div>
            <button>login</button>
        </form>
    </div>
</body>
</html>