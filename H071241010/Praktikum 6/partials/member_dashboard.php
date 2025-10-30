<?php
$member_id = $_SESSION['user_id'];

// Logika Update Status Tugas
if (isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $stmt = $koneksi->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("sii", $status, $task_id, $member_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo '<div class="alert alert-success">Status tugas berhasil diperbarui.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: Gagal memperbarui status.</div>';
        }
    } else {
         echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

// Ambil semua tugas yang ditugaskan ke member ini
$tasks_result = $koneksi->prepare("
    SELECT t.*, p.nama_proyek, u.username AS manager_name
    FROM tasks t
    JOIN projects p ON t.project_id = p.id
    JOIN users u ON p.manager_id = u.id
    WHERE t.assigned_to = ?
    ORDER BY p.id, t.id
");
$tasks_result->bind_param("i", $member_id);
$tasks_result->execute();
$my_tasks = $tasks_result->get_result();
?>

<h2>Dashboard Team Member</h2>
<hr>

<div class="card mb-4">
    <div class="card-header">
        <h4>Tugas Saya</h4>
    </div>
    <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tugas</th>
                    <th>Deskripsi</th>
                    <th>Proyek</th>
                    <th>Manajer Proyek</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = $my_tasks->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                    <td><?php echo htmlspecialchars($task['deskripsi']); ?></td>
                    <td><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                    <td><?php echo htmlspecialchars($task['manager_name']); ?></td>
                    <td>
                        <?php
                            $status = htmlspecialchars($task['status']);
                            $badge_class = 'bg-secondary';
                            if ($status == 'proses') $badge_class = 'bg-primary';
                            if ($status == 'selesai') $badge_class = 'bg-success';
                            echo "<span class='badge $badge_class'>$status</span>";
                        ?>
                    </td>
                    <td>
                        <form action="dashboard.php" method="POST" class="d-flex">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="belum" <?php if($task['status'] == 'belum') echo 'selected'; ?>>Belum</option>
                                <option value="proses" <?php if($task['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                <option value="selesai" <?php if($task['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>