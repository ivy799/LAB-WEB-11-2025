<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Project Management</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; margin: 0; }
        .login-container { padding: 30px; border-radius: 8px; background-color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; color: #555; }
        input { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .error-message { color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Please Login</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">Invalid Username or Password!</div>';
        }
        ?>
        <form action="process_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>