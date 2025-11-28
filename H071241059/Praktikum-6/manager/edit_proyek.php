<?php
// 1. Sertakan file cek login & koneksi
include '../cek_login.php';
include '../koneksi.php';

// 2. Cek Role Manager
if ($_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}

// 3. Ambil data dari session
$username = $_SESSION['username'];
$manager_id = $_SESSION['user_id'];

// 4. Cek apakah ada ID di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: proyek_saya.php?error=noid");
    exit;
}

$project_id = $_GET['id'];

// 5. Query untuk mengambil data proyek yang akan diedit
// PENTING: Cek 'id' PROYEK dan 'manager_id' SESSION
// Ini untuk memastikan manager hanya bisa mengedit proyek miliknya.
$sql = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $project_id, $manager_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Proyek tidak ditemukan ATAU bukan milik manager ini
    header("location: proyek_saya.php?error=aksesditolak");
    exit;
}

// Ambil data proyek
$project_data = $result->fetch_assoc();

$stmt->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek - Project Manager</title>
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

        <h2 class="text-3xl font-bold mb-4">Edit Proyek: <?php echo htmlspecialchars($project_data['nama_proyek']); ?></h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl">
            
            <form action="proses_proyek.php?action=edit" method="POST">
                
                <input type="hidden" name="id" value="<?php echo $project_data['id']; ?>">

                <div class="mb-4">
                    <label for="nama_proyek" class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                    <input type="text" id="nama_proyek" name="nama_proyek" required
                           value="<?php echo htmlspecialchars($project_data['nama_proyek']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                     focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($project_data['deskripsi']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</Klabel>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                               value="<?php echo htmlspecialchars($project_data['tanggal_mulai']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai (Estimasi)</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                               value="<?php echo htmlspecialchars($project_data['tanggal_selesai']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                   text-white bg-indigo-600 hover:bg-indigo-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Proyek
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>