<?php
// 1. Sertakan file cek login
include '../cek_login.php';

// 2. Cek Role Manager
if ($_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session (untuk navbar & form)
$username = $_SESSION['username'];
// Ini adalah ID manajer yang akan dimasukkan ke database
$manager_id = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Proyek Baru - Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-green-700 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Manajemen Proyek - Manager</h1>
            <div>
                <span class="mr-4">Halo, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 mt-6">
        
        <div class="mb-6">
            <a href="proyek_saya.php" class="text-green-600 hover:underline">&larr; Kembali ke Proyek Saya</a>
        </div>

        <h2 class="text-3xl font-bold mb-4">Buat Proyek Baru</h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl">
            
            <form action="proses_proyek.php?action=tambah" method="POST">
                
                <input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">

                <div class="mb-4">
                    <label for="nama_proyek" class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                    <input type="text" id="nama_proyek" name="nama_proyek" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                     focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Jelaskan detail proyek di sini..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</Klabel>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai (Estimasi)</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                   text-white bg-blue-600 hover:bg-blue-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Proyek
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>