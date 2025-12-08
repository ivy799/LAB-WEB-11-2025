<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require_once ("data.php");

$current_user = $_SESSION['user'];
$is_admin = $current_user['username'] === 'adminxxx';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <style>
        /* Gaya Flat Minimalist */
        body {
            font-family: Arial, sans-serif; /* Font standar yang mudah dibaca */
            background-color: #f9f9f9; /* Latar abu-abu sangat muda */
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ddd; /* Border tipis pengganti shadow */
        }

        /* Header sederhana dengan Flexbox */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 2px solid #333; /* Garis tebal hitam di bawah judul */
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 1.5em;
            margin: 0;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Link Logout Teks Saja */
        a.logout-link {
            color: #d00;
            text-decoration: none;
            font-size: 0.9em;
            font-weight: bold;
            text-transform: uppercase;
        }

        a.logout-link:hover {
            text-decoration: underline;
        }

        h2 {
            font-size: 1.1em;
            margin-top: 0;
            margin-bottom: 15px;
            color: #555;
            font-weight: normal;
            border-left: 3px solid #333;
            padding-left: 10px;
        }

        /* Tabel Flat */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }

        th {
            text-align: left;
            padding: 10px 0;
            border-bottom: 1px solid #999;
            color: #000;
        }

        td {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        /* Menghilangkan border baris terakhir */
        tr:last-child td {
            border-bottom: none;
        }

        /* Label tebal untuk data user */
        .label-col {
            width: 150px;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><?php echo $is_admin ? 'Admin Panel' : 'User Dashboard'; ?></h1>
        <a href="logout.php" class="logout-link">[ Keluar ]</a>
    </div>

    <?php if ($is_admin): ?>
        <h2>Data Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: 
        $user_display_data = [
            'Nama Lengkap' => $current_user['name'],
            'Username' => $current_user['username'],
            'Email' => $current_user['email'],
            'Fakultas' => $current_user['faculty'] ?? '-',
            'Angkatan' => $current_user['batch'] ?? '-'
        ];
    ?>
        <h2>Profil Saya</h2>
        <table>
            <?php foreach ($user_display_data as $label => $value): ?>
                <tr>
                    <td class="label-col"><?php echo $label; ?></td>
                    <td><?php echo htmlspecialchars($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>