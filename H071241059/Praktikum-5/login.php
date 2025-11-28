<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error_message = '';
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            width: 300px;
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd; /* Border kotak sederhana */
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 1.2em;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85em;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Border input standar */
            border-radius: 0; /* Sudut tajam */
            font-size: 1em;
        }

        input:focus {
            outline: 1px solid #333;
            border-color: #333;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #333; /* Tombol hitam solid */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #555;
        }

        .error {
            background-color: #ffe6e6;
            color: #d00;
            padding: 10px;
            font-size: 0.85em;
            margin-bottom: 15px;
            border: 1px solid #ffcccc;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Sistem</h2>

    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>