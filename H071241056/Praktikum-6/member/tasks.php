<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'team') {
    header("Location: ../auth/login.php");
    exit();
}

$member_id = $_SESSION['user_id'];

// Update task status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $task_id = mysqli_real_escape_string($conn, $_POST['task_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Verify ownership
    $verify_sql = "SELECT id FROM tasks WHERE id = '$task_id' AND assigned_to = '$member_id'";
    $verify_result = mysqli_query($conn, $verify_sql);
    
    if (mysqli_num_rows($verify_result) == 1) {
        $sql = "UPDATE tasks SET status = '$status' WHERE id = '$task_id'";
        mysqli_query($conn, $sql);
    }
    header("Location: tasks.php");
    exit();
}

// Get member's tasks with project info
$tasks_sql = "SELECT t.*, p.nama_proyek, p.deskripsi as project_desc 
              FROM tasks t 
              JOIN projects p ON t.project_id = p.id 
              WHERE t.assigned_to = '$member_id' 
              ORDER BY t.id DESC";
$tasks_result = mysqli_query($conn, $tasks_sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tugas Saya</h1>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Tugas yang Ditugaskan ke Saya</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Deskripsi</th>
                        <th>Proyek</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($task = mysqli_fetch_assoc($tasks_result)): ?>
                    <tr>
                        <td><?php echo $task['nama_tugas']; ?></td>
                        <td><?php echo $task['deskripsi']; ?></td>
                        <td>
                            <strong><?php echo $task['nama_proyek']; ?></strong><br>
                            <small><?php echo $task['project_desc']; ?></small>
                        </td>
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
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="belum" <?php echo $task['status'] == 'belum' ? 'selected' : ''; ?>>Belum</option>
                                    <option value="proses" <?php echo $task['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                                    <option value="selesai" <?php echo $task['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>