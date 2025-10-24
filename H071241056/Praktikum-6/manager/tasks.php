<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'projectmanager') {
    header("Location: ../auth/login.php");
    exit();
}

$manager_id = $_SESSION['user_id'];

// Add Task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $project_id = mysqli_real_escape_string($conn, $_POST['project_id']);
    $assigned_to = mysqli_real_escape_string($conn, $_POST['assigned_to']);
    
    $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) 
            VALUES ('$nama_tugas', '$deskripsi', '$project_id', '$assigned_to')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    
    $verify_sql = "SELECT t.id FROM tasks t 
                   JOIN projects p ON t.project_id = p.id 
                   WHERE t.id = '$id' AND p.manager_id = '$manager_id'";
    $verify_result = mysqli_query($conn, $verify_sql);
    
    if (mysqli_num_rows($verify_result) == 1) {
        $sql = "DELETE FROM tasks WHERE id = '$id'";
        mysqli_query($conn, $sql);
    }
    header("Location: tasks.php");
    exit();
}

$projects_sql = "SELECT * FROM projects WHERE manager_id = '$manager_id'";
$projects_result = mysqli_query($conn, $projects_sql);

$members_sql = "SELECT * FROM users WHERE project_manager_id = '$manager_id' AND role = 'team'";
$members_result = mysqli_query($conn, $members_sql);

$tasks_sql = "SELECT t.*, p.nama_proyek, u.username as assigned_name 
              FROM tasks t 
              JOIN projects p ON t.project_id = p.id 
              LEFT JOIN users u ON t.assigned_to = u.id 
              WHERE p.manager_id = '$manager_id' 
              ORDER BY t.id DESC";
$tasks_result = mysqli_query($conn, $tasks_sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Tugas</h1>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Tambah Tugas Baru</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="nama_tugas" placeholder="Nama Tugas" required>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="project_id" required>
                        <option value="">Pilih Proyek</option>
                        <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                            <option value="<?php echo $project['id']; ?>"><?php echo $project['nama_proyek']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="assigned_to" required>
                        <option value="">Pilih Team Member</option>
                        <?php while ($member = mysqli_fetch_assoc($members_result)): ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo $member['username']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Tugas" rows="2"></textarea>
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" name="add_task" class="btn btn-primary">Tambah Tugas</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Tugas</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Deskripsi</th>
                        <th>Proyek</th>
                        <th>Ditugaskan ke</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($task = mysqli_fetch_assoc($tasks_result)): ?>
                    <tr>
                        <td><?php echo $task['nama_tugas']; ?></td>
                        <td><?php echo $task['deskripsi']; ?></td>
                        <td><?php echo $task['nama_proyek']; ?></td>
                        <td><?php echo $task['assigned_name']; ?></td>
                        <td>
                            <span class="badge bg-<?php 
                                switch($task['status']) {
                                    case 'selesai': echo 'success'; break;
                                    case 'proses': echo 'warning'; break;
                                    default: echo 'secondary';
                                }
                            ?>">
                                <?php echo ucfirst($task['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="?delete=<?php echo $task['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus tugas ini?')">
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