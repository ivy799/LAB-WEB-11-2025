<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'superadmin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM projects WHERE id = '$id'";
    mysqli_query($conn, $sql);
    header("Location: manage_projects.php");
    exit();
}

$projects_sql = "SELECT p.*, u.username as manager_name 
                 FROM projects p 
                 JOIN users u ON p.manager_id = u.id 
                 ORDER BY p.tanggal_mulai DESC";
$projects_result = mysqli_query($conn, $projects_sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Semua Proyek</h1>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Semua Proyek</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek</th>
                        <th>Deskripsi</th>
                        <th>Manager</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                    <tr>
                        <td><?php echo $project['id']; ?></td>
                        <td><?php echo $project['nama_proyek']; ?></td>
                        <td><?php echo substr($project['deskripsi'], 0, 50) . '...'; ?></td>
                        <td><?php echo $project['manager_name']; ?></td>
                        <td><?php echo $project['tanggal_mulai']; ?></td>
                        <td><?php echo $project['tanggal_selesai']; ?></td>
                        <td>
                            <a href="?delete=<?php echo $project['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus proyek ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>