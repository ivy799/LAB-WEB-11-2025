<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Sistem Praktikum</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      overflow: hidden;
    }
    .login-box {
      backdrop-filter: blur(16px) saturate(180%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      background-color: rgba(255, 255, 255, 0.25);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 45px 40px;
      width: 360px;
      text-align: center;
      box-shadow: 0 8px 30px rgba(0,0,0,0.25);
      color: #fff;
      animation: fadeIn 0.7s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      margin-bottom: 10px;
      font-size: 26px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    p {
      color: #e0e0e0;
      font-size: 14px;
      margin-bottom: 25px;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      outline: none;
      background: rgba(255, 255, 255, 0.8);
      color: #333;
      transition: 0.3s;
    }
    input:focus {
      background: #fff;
      box-shadow: 0 0 0 3px rgba(85, 99, 222, 0.2);
    }
    button {
      width: 100%;
      background: linear-gradient(135deg, #5563DE, #74ABE2);
      border: none;
      color: white;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }
    .error {
      background: rgba(255, 90, 90, 0.2);
      color: #fff;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      font-size: 14px;
    }
    footer {
      margin-top: 25px;
      font-size: 12px;
      color: #eaeaea;
      opacity: 0.8;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Selamat Datang 👋</h2>
    <p>Loginki dulu</p>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="proses_login.php">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>
    <footer>© 2025 Sistem Praktikum PHP</footer>
  </div>
</body>
</html>
