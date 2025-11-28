<?php
// ... Bagian PHP LOGIC (Query, Include) TETAP SAMA SEPERTI ASLINYA ...
include '../cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] != 'manager') {
    header("location: ../login.php?error=aksesditolak");
    exit;
}
$username = $_SESSION['username'];
$manager_id = $_SESSION['user_id'];

// Query (sama persis)
$sql = "SELECT p.id, p.nama_proyek, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai, COUNT(t.id) AS jumlah_tugas, SUM(CASE WHEN t.status = 'selesai' THEN 1 ELSE 0 END) AS tugas_selesai FROM projects p LEFT JOIN tasks t ON p.id = t.project_id WHERE p.manager_id = ? GROUP BY p.id, p.nama_proyek, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai ORDER BY p.tanggal_mulai DESC";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <a href="dashboard.php" class="text-lg font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <span class="text-slate-400 font-normal">&larr;</span> Proyek Saya
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500"><?php echo htmlspecialchars($username); ?></span>
                <a href="../logout.php" class="text-sm text-red-600 hover:text-red-800 font-medium">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-6xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Daftar Proyek</h2>
                <p class="text-slate-500 text-sm">Kelola semua proyek aktif Anda di sini.</p>
            </div>
            <a href="tambah_proyek.php" class="bg-slate-900 hover:bg-slate-800 text-white font-medium py-2 px-5 rounded-lg shadow-sm transition text-sm">
                + Proyek Baru
            </a>
        </div>

        <?php
        if (isset($_GET['status'])) {
            $msg = '';
            $color = 'text-green-700 bg-green-50 border-green-200';
            if ($_GET['status'] == 'gagal_hapus') {
                $msg = 'Gagal menghapus proyek. Error: ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
                $color = 'text-red-700 bg-red-50 border-red-200';
            } else {
                $msg = 'Aksi berhasil dilakukan.';
            }
            echo '<div class="mb-6 p-4 border rounded-lg text-sm '.$color.'">'.$msg.'</div>';
        }
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): 
                    $progress = 0;
                    if ($row['jumlah_tugas'] > 0) {
                        $progress = ($row['tugas_selesai'] / $row['jumlah_tugas']) * 100;
                    }
                ?>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="p-5 flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-slate-900 line-clamp-1" title="<?php echo htmlspecialchars($row['nama_proyek']); ?>">
                                <?php echo htmlspecialchars($row['nama_proyek']); ?>
                            </h3>
                        </div>
                        
                        <p class="text-slate-500 text-sm mb-4 line-clamp-3 h-16 leading-relaxed">
                            <?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?>
                        </p>
                        
                        <div class="text-xs text-slate-400 space-y-1 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-16">Mulai:</span> 
                                <span class="text-slate-600 font-medium"><?php echo date("d M Y", strtotime($row['tanggal_mulai'])); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-16">Selesai:</span> 
                                <span class="text-slate-600 font-medium"><?php echo date("d M Y", strtotime($row['tanggal_selesai'])); ?></span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-500">Progress</span>
                                <span class="text-slate-700 font-semibold"><?php echo round($progress); ?>%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                            </div>
                            <div class="text-xs text-slate-400 mt-1 text-right">
                                <?php echo $row['tugas_selesai']; ?>/<?php echo $row['jumlah_tugas']; ?> Tugas Selesai
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 p-4 bg-slate-50/50 rounded-b-xl flex items-center justify-between">
                        <a href="kelola_tugas.php?project_id=<?php echo $row['id']; ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Kelola Tugas &rarr;
                        </a>
                        <div class="space-x-3 text-sm">
                            <a href="edit_proyek.php?id=<?php echo $row['id']; ?>" class="text-slate-500 hover:text-slate-800">Edit</a>
                            <a href="proses_proyek.php?action=hapus&id=<?php echo $row['id']; ?>" 
                               class="text-red-400 hover:text-red-600"
                               onclick="return confirm('Hapus proyek ini beserta semua tugasnya?');">
                               Hapus
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-12 text-center bg-white border border-dashed border-slate-300 rounded-xl">
                    <p class="text-slate-500">Belum ada proyek.</p>
                    <a href="tambah_proyek.php" class="text-indigo-600 font-medium hover:underline mt-2 inline-block">Buat Proyek Baru</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$koneksi->close();
?>