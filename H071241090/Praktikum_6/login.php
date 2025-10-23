<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Manajemen Proyek</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-700">Login</h1>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <form action="login_logic.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-600 mb-1">Username</label>
        <input type="text" name="username" required
          class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-600 mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <button type="submit"
        class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition">
        Login
      </button>
    </form>
  </div>

</body>
</html>
