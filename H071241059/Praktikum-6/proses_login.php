<?php
// 1. Mulai Session
// Session penting untuk 'mengingat' siapa yang login
session_start();

// 2. Sertakan file koneksi
include 'koneksi.php';

// 3. Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 4. Ambil data dari form
    // Kita gunakan htmlspecialchars untuk keamanan dasar
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // 5. Siapkan Query SQL (Gunakan Prepared Statements)
    // Ini sangat penting untuk mencegah SQL Injection
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    
    $stmt = $koneksi->prepare($sql);
    
    if ($stmt === false) {
        die("Error persiapan query: " . $koneksi->error);
    }
    
    // 's' berarti kita binding 1 parameter string
    $stmt->bind_param("s", $username);
    
    // 6. Eksekusi Query
    $stmt->execute();
    
    // 7. Ambil hasil
    $result = $stmt->get_result();
    
    // 8. Cek apakah user ditemukan
    if ($result->num_rows == 1) {
        // User ditemukan, ambil datanya
        $user = $result->fetch_assoc();
        
        // 9. Verifikasi Password
        // Gunakan password_verify() untuk membandingkan password form
        // dengan hash yang ada di database
        
        if (password_verify($password, $user['password'])) {
            // == LOGIN BERHASIL ==
            
            // 10. Simpan data user ke dalam session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // 11. Arahkan (redirect) berdasarkan role
            if ($user['role'] == 'superadmin') {
                header("location: superadmin/dashboard.php");
            } elseif ($user['role'] == 'manager') {
                header("location: manager/dashboard.php");
            } elseif ($user['role'] == 'member') {
                header("location: member/dashboard.php");
            } else {
                // Role tidak dikenal, kembalikan ke login
                header("location: login.php?error=invalidrole");
            }
            exit; // Pastikan skrip berhenti setelah redirect

        } else {
            // == LOGIN GAGAL (PASSWORD SALAH) ==
            header("location: login.php?error=password");
            exit;
        }
        
    } else {
        // == LOGIN GAGAL (USERNAME TIDAK DITEMUKAN) ==
        header("location: login.php?error=username");
        exit;
    }
    
    // 12. Tutup statement
    $stmt->close();
    
} else {
    // Jika file diakses langsung tanpa POST, redirect ke login
    header("location: login.php");
    exit;
}

// 13. Tutup koneksi
$koneksi->close();

?>