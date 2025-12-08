<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg border border-slate-100 w-full max-w-sm">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
            <p class="text-slate-500 text-sm mt-1">Silakan login untuk masuk ke sistem</p>
        </div>
        
        <?php
        if (isset($_GET['error'])) {
            $error_msg = '';
            if ($_GET['error'] == 'password') {
                $error_msg = 'Password salah.';
            } elseif ($_GET['error'] == 'username') {
                $error_msg = 'Username tidak ditemukan.';
            } elseif ($_GET['error'] == 'invalidrole') {
                $error_msg = 'Role tidak valid.';
            } elseif ($_GET['error'] == 'sesihabis') {
                $error_msg = 'Sesi habis, silakan login lagi.';
            } else {
                $error_msg = 'Terjadi kesalahan.';
            }
            
            echo '<div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r">';
            echo htmlspecialchars($error_msg);
            echo '</div>';
        }
        
        if (isset($_GET['status']) && $_GET['status'] == 'logout') {
             echo '<div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r">Anda berhasil logout.</div>';
        }
        ?>
        
        <form action="proses_login.php" method="POST" class="space-y-5">
            <div>
                <label for="username" class="block text-sm font-semibold text-slate-700 mb-1">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition"
                    placeholder="Masukkan username"
                >
            </div>
            
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition"
                    placeholder="••••••••"
                >
            </div>
            
            <button 
                type="submit" 
                class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-200"
            >
                Masuk Sekarang
            </button>
            
        </form>
    </div>

</body>
</html>