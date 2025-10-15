<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(135deg, #eef2f3, #8e9eab);
      margin: 0;
      color: #333;
    }
    header {
      background: linear-gradient(120deg, #5563DE, #74ABE2);
      color: white;
      padding: 18px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    header h1 {
      margin: 0;
      font-size: 22px;
      font-weight: 600;
    }
    .logout {
      background: white;
      color: #5563DE;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s;
    }
    .logout:hover {
      background: #e7e9ff;
      transform: translateY(-2px);
    }
    main {
      padding: 40px;
      display: flex;
      flex-direction: column;
      gap: 25px;
    }
    .card {
      background: rgba(255, 255, 255, 0.85);
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      backdrop-filter: blur(12px);
      animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2, h3 {
      color: #3440A1;
      margin-top: 0;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 15px;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: #5563DE;
      color: white;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.05em;
    }
    tr:hover {
      background: rgba(85,99,222,0.05);
    }
  </style>
</head>
<body>
  <header>
    <h1>Dashboard </h1>
    <a href="logout.php" class="logout">Logout</a>
  </header>
  
  <main>
    <div class="card">
      <h2>Selamat Datang, <?= htmlspecialchars($user['name']); ?>!</h2>
      <p>Pak Prabowo nitip pesan: janganki bede lupa makan yang bergizi hari ini 😊 </p>
    </div>

    <?php if ($user['username'] === 'adminxxx'): ?>
      <div class="card">
        <h3>Daftar Seluruh Pengguna</h3>
        <table>
          <tr><th>Nama</th><th>Username</th><th>Email</th></tr>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['name'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($u['username']); ?></td>
              <td><?= htmlspecialchars($u['email']); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php else: ?>
      <div class="card">
        <h3>Profil Anda</h3>
        <table>
          <tr><th>Nama</th><td><?= htmlspecialchars($user['name']); ?></td></tr>
          <tr><th>Email</th><td><?= htmlspecialchars($user['email']); ?></td></tr>
          <tr><th>Username</th><td><?= htmlspecialchars($user['username']); ?></td></tr>
          <tr><th>Gender</th><td><?= htmlspecialchars($user['gender'] ?? '-'); ?></td></tr>
          <tr><th>Fakultas</th><td><?= htmlspecialchars($user['faculty'] ?? '-'); ?></td></tr>
          <tr><th>Angkatan</th><td><?= htmlspecialchars($user['batch'] ?? '-'); ?></td></tr>
        </table>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
