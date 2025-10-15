<?php
session_start();
require "data.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f9fafc;
            color: #333;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.6;
        }

        h2 {
            text-align: center;
            color: #2b3a67;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin: 10px 0 20px;
            text-decoration: none;
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            transition: background-color 0.2s ease;

        }

        a:hover {
            background-color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px 12px;
            text-align: left;
        }

        th {
            background-color: #f0f4f8;
            color: #333;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        ul {
            list-style: none;
            padding: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            padding: 15px 20px;
            margin-top: 10px;
        }

        ul li {
            margin: 6px 0;
        }
    </style>

</head>

<body>
    <?php if ($user['username'] === 'adminxxx'): ?>
        <h2>Selamat Datang, Admin!</h2>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Fakultas</th>
                    <th>Angkatan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['email'] ?></td>
                        <td><?= $u['username'] ?></td>
                        <td><?= $u['name'] ?></td>
                        <td><?= $u['gender'] ?? '-' ?></td>
                        <td><?= $u['faculty'] ?? '-' ?></td>
                        <td><?= $u['batch'] ?? '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <a href="logout.php">Logout</a>
        </table>
    <?php else: ?>
        <h2>Selamat Datang, <?= htmlspecialchars($user['name']) ?>!</h2>
        <ul>
            <li>Email: <?= $user['email'] ?></li>
            <li>Username: <?= $user['username'] ?></li>
            <li>Gender: <?= $user['gender'] ?? '-' ?></li>
            <li>Fakultas: <?= $user['faculty'] ?? '-' ?></li>
            <li>Angkatan: <?= $user['batch'] ?? '-' ?></li>
        </ul>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</body>
</html>
