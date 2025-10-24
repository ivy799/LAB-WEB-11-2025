<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'superadmin') {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $project_manager_id = $_POST['project_manager_id'] ?: NULL;
    
    $sql = "INSERT INTO users (username, password, role, project_manager_id) 
            VALUES ('$username', '$password', '$role', '$project_manager_id')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM users WHERE id = '$id' AND role != 'superadmin'";
    mysqli_query($conn, $sql);
    header("Location: manage_users.php");
    exit();
}

$users_sql = "SELECT u.*, m.username as manager_name 
              FROM users u 
              LEFT JOIN users m ON u.project_manager_id = m.id 
              WHERE u.role != 'superadmin' 
              ORDER BY u.role, u.username";
$users_result = mysqli_query($conn, $users_sql);

// Get project managers for dropdown
$managers_sql = "SELECT * FROM users WHERE role = 'projectmanager'";
$managers_result = mysqli_query($conn, $managers_sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Pengguna</h1>
</div>

<!-- Add User Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5>Tambah Pengguna Baru</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="col-md-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="role" id="roleSelect" required>
                        <option value="">Pilih Role</option>
                        <option value="projectmanager">Project Manager</option>
                        <option value="team">Team Member</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="project_manager_id" id="managerSelect" style="display: none;">
                        <option value="">Pilih Project Manager</option>
                        <?php while ($manager = mysqli_fetch_assoc($managers_result)): ?>
                            <option value="<?php echo $manager['id']; ?>"><?php echo $manager['username']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" name="add_user" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Pengguna</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Project Manager</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td>
                            <span class="badge bg-<?php 
                                echo $user['role'] == 'projectmanager' ? 'warning' : 'info'; 
                            ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td><?php echo $user['manager_name'] ?: '-'; ?></td>
                        <td>
                            <a href="?delete=<?php echo $user['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
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

<script>
document.getElementById('roleSelect').addEventListener('change', function() {
    var managerSelect = document.getElementById('managerSelect');
    if (this.value === 'team') {
        managerSelect.style.display = 'block';
        managerSelect.required = true;
    } else {
        managerSelect.style.display = 'none';
        managerSelect.required = false;
    }
});
</script>

<?php include '../includes/footer.php'; ?>