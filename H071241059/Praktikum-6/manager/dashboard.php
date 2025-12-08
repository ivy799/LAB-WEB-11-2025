<?php
// 1. Sertakan file cek login
include '../cek_login.php';

// 2. Cek apakah role-nya = manager
if ($_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-slate-800 text-white p-1.5 rounded text-xs font-bold">PM</div>
                <h1 class="text-lg font-bold tracking-tight text-slate-800">Manajemen Proyek</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500">Halo, <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($username); ?></span></span>
                <a href="../logout.php" class="text-sm text-red-600 hover:text-red-800 font-medium transition">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        <div class="mb-8 mt-4">
            <h2 class="text-3xl font-bold text-slate-900">Dashboard</h2>
            <p class="text-slate-500 mt-2">Pantau proyek dan kelola tugas tim Anda dengan mudah.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="proyek_saya.php" class="group block p-6 bg-white rounded-xl border border-slate-200 hover:border-indigo-500 hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition">Proyek Saya</h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">Kelola data proyek, edit deskripsi, dan pantau durasi pengerjaan.</p>
                    </div>
                    <span class="bg-slate-100 p-2 rounded-lg text-slate-600 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </span>
                </div>
            </a>

            <a href="kelola_tugas.php" class="group block p-6 bg-white rounded-xl border border-slate-200 hover:border-emerald-500 hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition">Tugas Tim (Via Proyek)</h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">Delegasikan tugas ke anggota tim dan update status pengerjaan.</p>
                        <p class="text-xs text-slate-400 mt-2 italic">*Akses melalui detail proyek</p>
                    </div>
                    <span class="bg-slate-100 p-2 rounded-lg text-slate-600 group-hover:bg-emerald-50 group-hover:text-emerald-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </span>
                </div>
            </a>
        </div>
    </div>

</body>
</html>