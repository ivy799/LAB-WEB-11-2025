<?php
session_start();

$message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-sm">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 text-center">
            Masuk ke Sistem
        </h2>

        <?php if (!empty($message)) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-center font-medium">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="proses_login.php" class="space-y-6">
            <input
                type="text"
                name="username"
                placeholder="Username"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none
                       focus:ring-2 focus:ring-blue-500 text-gray-700 text-base sm:text-lg"
            >

            <div class="relative">
                <input
                    id="passwordInput"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-blue-500 text-gray-700 text-base sm:text-lg pr-12"
                >
                <button
                    id="togglePassword"
                    type="button"
                    aria-pressed="false"
                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-700 hover:text-gray-900 focus:outline-none"
                >
                    <span id="toggleEmoji">👁️</span>
                </button>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3
                       rounded-lg text-base sm:text-lg transition transform hover:scale-105"
            >
                Masuk
            </button>
        </form>
    </div>

    <script>
        (function(){
            const pwdInput = document.getElementById('passwordInput');
            const toggleBtn = document.getElementById('togglePassword');
            const toggleEmoji = document.getElementById('toggleEmoji');

            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                toggleEmoji.textContent = isPassword ? '🙈' : '👁️';
                toggleBtn.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        })();
    </script>

</body>
</html>
