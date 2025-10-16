<?php

session_start();


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}


$user = $_SESSION['user'];


require_once 'data.php';


$is_admin = ($user['username'] == 'adminxxx');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
            padding: 30px;
            color: #374151;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        h1 {
            color: #111827;
            font-size: 32px;
            font-weight: 600;
        }
        
        h3 {
            color: #111827;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .logout-btn {
            padding: 10px 20px;
            background-color: #6B8A7A;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(107, 138, 122, 0.2);
        }
        
        .logout-btn:hover {
            background-color: #5A756A; 
            box-shadow: 0 4px 15px rgba(107, 138, 122, 0.25);
            transform: translateY(-2px);
        }
        
        .welcome-message {
            background-color: #EAF0ED; 
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid #6B8A7A; 
        }
        
        .welcome-message h2 {
            color: #111827;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .welcome-message p {
            color: #374151;
            font-size: 16px;
        }
        
        .user-info {
            background-color: #f9fafb;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 16px;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            width: 180px;
            color: #111827;
        }
        
        .info-value {
            color: #374151;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th,
        table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        
        table th {
            background-color: #f9fafb;
            color: #4b5563;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }
        
        table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        table td {
            color: #374151;
        }
        
        .badge {
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        
        .badge-admin {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-user {
            background-color: #DDE7E4; 
            color: #305D5B;      
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php if ($is_admin): ?>
            <div class="welcome-message">
                <h2>Selamat Datang, Admin!</h2>
                <p>Anda memiliki akses penuh untuk melihat data semua pengguna.</p>
            </div>
            
            <h3>Data Semua Pengguna</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Fakultas</th>
                        <th>Angkatan</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($users as $u): 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($u['name']); ?></td>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo array_key_exists('gender', $u) ? htmlspecialchars($u['gender']) : '-'; ?></td>
                        <td><?php echo array_key_exists('faculty', $u) ? htmlspecialchars($u['faculty']) : '-'; ?></td>
                        <td><?php echo array_key_exists('batch', $u) ? htmlspecialchars($u['batch']) : '-'; ?></td>
                        <td>
                            <span class="badge <?php echo ($u['username'] == 'adminxxx') ? 'badge-admin' : 'badge-user'; ?>">
                                <?php echo ($u['username'] == 'adminxxx') ? 'Admin' : 'User'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        <?php else: ?>
            <div class="welcome-message">
                <h2>Selamat Datang, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <p>Ini adalah halaman informasi profil Anda.</p>
            </div>
            
            <div class="user-info">
                <h3>Informasi Profil</h3>
                
                <div class="info-row">
                    <div class="info-label">Nama Lengkap:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['name']); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Username:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
                
                <?php if (array_key_exists('gender', $user)): ?>
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['gender']); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if (array_key_exists('faculty', $user)): ?>
                <div class="info-row">
                    <div class="info-label">Fakultas:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['faculty']); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if (array_key_exists('batch', $user)): ?>
                <div class="info-row">
                    <div class="info-label">Angkatan:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['batch']); ?></div>
                </div>
                <?php endif; ?>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>