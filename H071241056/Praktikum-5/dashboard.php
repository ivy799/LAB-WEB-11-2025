<?php
session_start();
require 'data.php'; 

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php if ($user['username'] === 'adminxxx'): ?>
    <h2>Selamat Datang, Admin!</h2>
    <table border="1" cellpadding="5">
      <tr>
        <th>Nama</th>
        <th>Username</th>
        <th>Email</th>
      </tr>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['name'] ?></td>
          <td><?= $u['username'] ?></td>
          <td><?= $u['email'] ?? '-' ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

  <?php else: ?>
  <div class="container">
    <h2>Selamat Datang, <?= htmlspecialchars($user['name']); ?>!</h2>

    <table>
      <tr>
        <th>Field</th>
        <th>Data</th>
      </tr>
      <tr>
        <td>Email</td>
        <td><?= htmlspecialchars($user['email']); ?></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?= htmlspecialchars($user['username']); ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?= htmlspecialchars($user['gender'] ?? 'Tidak diketahui'); ?></td>
      </tr>
      <tr>
        <td>Fakultas</td>
        <td><?= htmlspecialchars($user['faculty'] ?? 'Tidak diketahui'); ?></td>
      </tr>
      <tr>
        <td>Angkatan</td>
        <td><?= htmlspecialchars($user['batch'] ?? 'Tidak diketahui'); ?></td>
      </tr>
    </table>

    <a href="logout.php" class="logout">Logout</a>
  </div>
<?php endif; ?>
</body>
</html>
