<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'projectmanager') {
    header("Location: ../auth/login.php");
    exit();
}

$manager_id = $_SESSION['user_id'];

// VARIABEL UNTUK EDIT MODE
$edit_mode = false;
$editing_project = null;

// PROSES TAMBAH PROYEK BARU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_project'])) {
    $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);
    
    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) 
            VALUES ('$nama_proyek', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai', '$manager_id')";
    mysqli_query($conn, $sql);
    $_SESSION['success'] = "Proyek berhasil ditambahkan!";
    header("Location: projects.php");
    exit();
}

// PROSES UPDATE PROYEK
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_project'])) {
    $id = mysqli_real_escape_string($conn, $_POST['project_id']);
    $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);
    
    // VERIFIKASI: Pastikan proyek milik manager yang login
    $verify_sql = "SELECT id FROM projects WHERE id = '$id' AND manager_id = '$manager_id'";
    $verify_result = mysqli_query($conn, $verify_sql);
    
    if (mysqli_num_rows($verify_result) == 1) {
        $sql = "UPDATE projects SET 
                nama_proyek = '$nama_proyek', 
                deskripsi = '$deskripsi', 
                tanggal_mulai = '$tanggal_mulai', 
                tanggal_selesai = '$tanggal_selesai' 
                WHERE id = '$id'";
        mysqli_query($conn, $sql);
        $_SESSION['success'] = "Proyek berhasil diupdate!";
    }
    header("Location: projects.php");
    exit();
}

// TOGGLE EDIT MODE - Ambil data proyek yang akan diedit
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($conn, $_GET['edit']);
    
    // VERIFIKASI: Pastikan proyek milik manager yang login
    $verify_sql = "SELECT * FROM projects WHERE id = '$id' AND manager_id = '$manager_id'";
    $verify_result = mysqli_query($conn, $verify_sql);
    
    if (mysqli_num_rows($verify_result) == 1) {
        $edit_mode = true;
        $editing_project = mysqli_fetch_assoc($verify_result);
    }
}

// CANCEL EDIT MODE
if (isset($_GET['cancel_edit'])) {
    header("Location: projects.php");
    exit();
}

// PROSES DELETE PROYEK
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);

    $verify_sql = "SELECT id FROM projects WHERE id = '$id' AND manager_id = '$manager_id'";
    $verify_result = mysqli_query($conn, $verify_sql);
    
    if (mysqli_num_rows($verify_result) == 1) {
        $sql = "DELETE FROM projects WHERE id = '$id'";
        mysqli_query($conn, $sql);
        $_SESSION['success'] = "Proyek berhasil dihapus!";
    }
    header("Location: projects.php");
    exit();
}

// AMBIL DATA PROYEK
$projects_sql = "SELECT * FROM projects WHERE manager_id = '$manager_id' ORDER BY tanggal_mulai DESC";
$projects_result = mysqli_query($conn, $projects_sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Proyek Saya</h1>
</div>

<!-- TAMPILKAN PESAN SUKSES -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- FORM TAMBAH/EDIT PROYEK -->
<div class="card mb-4">
    <div class="card-header">
        <h5><?php echo $edit_mode ? 'Edit Proyek' : 'Tambah Proyek Baru'; ?></h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="project_id" value="<?php echo $editing_project['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_proyek" 
                           placeholder="Nama Proyek" 
                           value="<?php echo $edit_mode ? htmlspecialchars($editing_project['nama_proyek']) : ''; ?>" 
                           required>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_mulai" 
                           value="<?php echo $edit_mode ? $editing_project['tanggal_mulai'] : ''; ?>" 
                           required>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_selesai" 
                           value="<?php echo $edit_mode ? $editing_project['tanggal_selesai'] : ''; ?>" 
                           required>
                </div>
                <div class="col-md-12 mt-2">
                    <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Proyek" rows="2"><?php echo $edit_mode ? htmlspecialchars($editing_project['deskripsi']) : ''; ?></textarea>
                </div>
                <div class="col-md-12 mt-2">
                    <?php if ($edit_mode): ?>
                        <button type="submit" name="update_project" class="btn btn-success">Update Proyek</button>
                        <a href="?cancel_edit" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="add_project" class="btn btn-primary">Tambah Proyek</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL DAFTAR PROYEK -->
<div class="card">
    <div class="card-header">
        <h5>Daftar Proyek</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                        <td><?php echo htmlspecialchars($project['deskripsi']); ?></td>
                        <td><?php echo $project['tanggal_mulai']; ?></td>
                        <td><?php echo $project['tanggal_selesai']; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="?edit=<?php echo $project['id']; ?>" 
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a href="?delete=<?php echo $project['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>