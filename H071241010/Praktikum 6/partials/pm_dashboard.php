<?php
$pm_id = $_SESSION['user_id'];
$pesan_sukses = "";
$pesan_error = "";

$mode_edit_proyek = false;
$mode_edit_tugas = false;
$data_proyek_edit = null;
$data_tugas_edit = null;


// --- Logika Proyek ---

// Logika Tambah Proyek
if (isset($_POST['add_project'])) {
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $stmt = $koneksi->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $pm_id);
    if ($stmt->execute()) {
        $pesan_sukses = "Proyek baru berhasil dibuat.";
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

//: Logika Update Proyek
if (isset($_POST['update_project'])) {
    $project_id = $_POST['project_id'];
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    // Update proyek (Cek kepemilikan)
    $stmt = $koneksi->prepare("UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?");
    $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $pm_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $pesan_sukses = "Proyek berhasil diperbarui.";
        } else {
            $pesan_error = "Gagal memperbarui proyek (Mungkin bukan milik Anda).";
        }
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_GET['delete_project_pm'])) {
    $project_id = $_GET['delete_project_pm'];
    
    $stmt_tasks = $koneksi->prepare("DELETE FROM tasks WHERE project_id = ?");
    $stmt_tasks->bind_param("i", $project_id);
    $stmt_tasks->execute();
    $stmt_tasks->close();
    
    $stmt = $koneksi->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
    $stmt->bind_param("ii", $project_id, $pm_id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $pesan_sukses = "Proyek berhasil dihapus.";
        } else {
            $pesan_error = "Gagal menghapus (Mungkin proyek bukan milik Anda).";
        }
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// --- Logika Tugas ---

// Logika Tambah Tugas
if (isset($_POST['add_task'])) {
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi_tugas = $_POST['deskripsi_tugas'];
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];
    // Status default 'belum' sudah di database

    $stmt = $koneksi->prepare("INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nama_tugas, $deskripsi_tugas, $project_id, $assigned_to);
    if ($stmt->execute()) {
        $pesan_sukses = "Tugas baru berhasil ditambahkan.";
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Logika Update Tugas
if (isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi_tugas = $_POST['deskripsi_tugas'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = $koneksi->prepare("
        UPDATE tasks t
        JOIN projects p ON t.project_id = p.id
        SET 
            t.nama_tugas = ?,
            t.deskripsi = ?,
            t.assigned_to = ?
        WHERE 
            t.id = ? 
            AND p.manager_id = ?
            AND t.status != 'selesai'
    ");
    $stmt->bind_param("ssiii", $nama_tugas, $deskripsi_tugas, $assigned_to, $task_id, $pm_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $pesan_sukses = "Tugas berhasil diperbarui.";
        } else {
            $pesan_error = "Gagal memperbarui (Tugas mungkin sudah 'selesai' atau bukan milik Anda).";
        }
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Logika Hapus Tugas (Hanya jika tugas statusnya BUKAN 'selesai')
if (isset($_GET['delete_task_pm'])) {
    $task_id = $_GET['delete_task_pm'];
    
    $stmt = $koneksi->prepare("
        DELETE t FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE 
            t.id = ? 
            AND p.manager_id = ?
            AND t.status != 'selesai'
    ");
    $stmt->bind_param("ii", $task_id, $pm_id);
     if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $pesan_sukses = "Tugas berhasil dihapus.";
        } else {
            $pesan_error = "Gagal menghapus (Tugas mungkin sudah 'selesai').";
        }
    } else {
        $pesan_error = "Error: " . $stmt->error;
    }
    $stmt->close();
}


//  Cek apakah sedang dalam mode edit
if (isset($_GET['edit_project'])) {
    $project_id_edit = $_GET['edit_project'];
    // Ambil data proyek HANYA JIKA milik PM
    $stmt = $koneksi->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
    $stmt->bind_param("ii", $project_id_edit, $pm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $mode_edit_proyek = true;
        $data_proyek_edit = $result->fetch_assoc();
    } else {
        $pesan_error = "Proyek tidak dapat diedit (Tidak ditemukan atau bukan milik Anda).";
    }
    $stmt->close();
}

// **BARU**: Cek apakah sedang dalam mode edit tugas
if (isset($_GET['edit_task'])) {
    $task_id_edit = $_GET['edit_task'];
    // Ambil data tugas HANYA JIKA milik PM dan status BUKAN 'selesai'
    $stmt = $koneksi->prepare("
        SELECT t.* FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.id = ? AND p.manager_id = ? AND t.status != 'selesai'
    ");
    $stmt->bind_param("ii", $task_id_edit, $pm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $mode_edit_tugas = true;
        $data_tugas_edit = $result->fetch_assoc();
    } else {
        $pesan_error = "Tugas tidak dapat diedit (Tidak ditemukan, bukan milik Anda, atau sudah selesai).";
    }
    $stmt->close();
}


// Ambil data (hanya milik PM ini)
$projects_result = $koneksi->prepare("SELECT * FROM projects WHERE manager_id = ? ORDER BY tanggal_mulai DESC");
$projects_result->bind_param("i", $pm_id);
$projects_result->execute();
$my_projects = $projects_result->get_result();

// Query 2: Untuk dropdown tambah tugas (jalankan query lagi)
$active_projects_result = $koneksi->prepare("SELECT * FROM projects WHERE manager_id = ? ORDER BY tanggal_mulai DESC");
$active_projects_result->bind_param("i", $pm_id);
$active_projects_result->execute();
$my_active_projects = $active_projects_result->get_result();


// Ambil data Team Member (hanya yang di bawah PM ini)
$members_result = $koneksi->prepare("SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = ?");
$members_result->bind_param("i", $pm_id);
$members_result->execute();
$my_members = $members_result->get_result();
?>

<h2>Dashboard Project Manager</h2>
<hr>

<?php
// Tampilkan pesan sukses atau error jika ada
if (!empty($pesan_sukses)) {
    echo '<div class="alert alert-success">' . $pesan_sukses . '</div>';
}
if (!empty($pesan_error)) {
    echo '<div class="alert alert-danger">' . $pesan_error . '</div>';
}
?>


<div class="card mb-4">
    <div class="card-header">
        <h4><?php echo $mode_edit_proyek ? 'Edit Proyek' : 'Proyek Saya'; ?></h4>
    </div>
    <div class="card-body">
        
        <?php if ($mode_edit_proyek): ?>
        <h5 class="mb-3">Edit Proyek: <?php echo htmlspecialchars($data_proyek_edit['nama_proyek']); ?></h5>
        <form action="dashboard.php" method="POST" class="mb-4 p-3 bg-light rounded">
             <input type="hidden" name="project_id" value="<?php echo $data_proyek_edit['id']; ?>">
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Proyek</label>
                    <input type="text" name="nama_proyek" class="form-control" value="<?php echo htmlspecialchars($data_proyek_edit['nama_proyek']); ?>" required>
                </div>
                 <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $data_proyek_edit['tanggal_mulai']; ?>" required>
                </div>
                 <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $data_proyek_edit['tanggal_selesai']; ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Proyek</label>
                    <textarea name="deskripsi" class="form-control" rows="2"><?php echo htmlspecialchars($data_proyek_edit['deskripsi']); ?></textarea>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="update_project" class="btn btn-success">Update Proyek</button>
                    <a href="dashboard.php" class="btn btn-secondary">Batal Edit</a>
                </div>
            </div>
        </form>

        <?php else: ?>
        <h5 class="mb-3">Buat Proyek Baru</h5>
        <form action="dashboard.php" method="POST" class="mb-4 p-3 bg-light rounded">
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Proyek</label>
                    <input type="text" name="nama_proyek" class="form-control" required>
                </div>
                 <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                 <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Proyek</label>
                    <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="add_project" class="btn btn-primary">Simpan Proyek</button>
                </div>
            </div>
        </form>
        <?php endif; // Selesai if mode edit proyek ?>
        
        <hr>
        
        <h5 class="mb-3">Daftar Proyek Saya</h5>
        <table class="table table-striped table-bordered">
             <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($project = $my_projects->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                    <td><?php echo htmlspecialchars($project['deskripsi']); ?></td>
                    <td><?php echo $project['tanggal_mulai']; ?> s/d <?php echo $project['tanggal_selesai']; ?></td>
                    <td>
                        <a href="dashboard.php?edit_project=<?php echo $project['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="dashboard.php?delete_project_pm=<?php echo $project['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus proyek ini? Semua tugas di dalamnya juga akan terhapus.')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header">
        <h4><?php echo $mode_edit_tugas ? 'Edit Tugas' : 'Tugas (Tasks)'; ?></h4>
    </div>
    <div class="card-body">
        
        <?php if ($mode_edit_tugas): ?>
        <h5 class="mb-3">Edit Tugas: <?php echo htmlspecialchars($data_tugas_edit['nama_tugas']); ?></h5>
        <form action="dashboard.php" method="POST" class="mb-4 p-3 bg-light rounded">
            <input type="hidden" name="task_id" value="<?php echo $data_tugas_edit['id']; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Tugas</label>
                    <input type="text" name="nama_tugas" class="form-control" value="<?php echo htmlspecialchars($data_tugas_edit['nama_tugas']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tugaskan Kepada</label>
                    <select name="assigned_to" class="form-select" required>
                        <option value="">-- Pilih Team Member --</option>
                        <?php while ($member = $my_members->fetch_assoc()): ?>
                        <option value="<?php echo $member['id']; ?>" <?php if($data_tugas_edit['assigned_to'] == $member['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($member['username']); ?>
                        </option>
                        <?php endwhile; ?>
                        <?php $my_members->data_seek(0); // Reset pointer ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Tugas</label>
                    <textarea name="deskripsi_tugas" class="form-control" rows="2"><?php echo htmlspecialchars($data_tugas_edit['deskripsi']); ?></textarea>
                </div>
                 <div class="col-md-12">
                    <button type="submit" name="update_task" class="btn btn-success">Update Tugas</button>
                    <a href="dashboard.php" class="btn btn-secondary">Batal Edit</a>
                </div>
            </div>
        </form>

        <?php elseif (!$mode_edit_proyek): // Jangan tampilkan "Add Task" jika sedang edit proyek ?>
        <h5 class="mb-3">Tambah Tugas Baru</h5>
        <form action="dashboard.php" method="POST" class="mb-4 p-3 bg-light rounded">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Tugas</label>
                    <input type="text" name="nama_tugas" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Untuk Proyek</label>
                    <select name="project_id" class="form-select" required>
                        <option value="">-- Pilih Proyek --</option>
                        <?php while ($project = $my_active_projects->fetch_assoc()): ?>
                        <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['nama_proyek']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                 <div class="col-md-3 mb-3">
                    <label class="form-label">Tugaskan Kepada</label>
                    <select name="assigned_to" class="form-select" required>
                        <option value="">-- Pilih Team Member --</option>
                        <?php while ($member = $my_members->fetch_assoc()): ?>
                        <option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['username']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Tugas</label>
                    <textarea name="deskripsi_tugas" class="form-control" rows="2"></textarea>
                </div>
                 <div class="col-md-12">
                    <button type="submit" name="add_task" class="btn btn-primary">Simpan Tugas</button>
                </div>
            </div>
        </form>
        <?php endif; ?>

        <hr>

        <h5 class="mb-3">Daftar Semua Tugas di Proyek Saya</h5>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tugas</th>
                    <th>Proyek</th>
                    <th>Ditugaskan Kepada</th>
                    <th>Status Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tasks_result = $koneksi->prepare("
                    SELECT t.*, p.nama_proyek, u.username AS member_name
                    FROM tasks t
                    JOIN projects p ON t.project_id = p.id
                    LEFT JOIN users u ON t.assigned_to = u.id
                    WHERE p.manager_id = ?
                    ORDER BY p.id, t.id
                ");
                $tasks_result->bind_param("i", $pm_id);
                $tasks_result->execute();
                $all_tasks = $tasks_result->get_result();
                
                while ($task = $all_tasks->fetch_assoc()):
                
                $is_task_done = ($task['status'] == 'selesai');
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                    <td><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                    <td><?php echo htmlspecialchars($task['member_name'] ?? 'N/A'); ?></td>
                    <td>
                        <?php
                            $status_tugas = htmlspecialchars($task['status']);
                            $badge_tugas = 'bg-secondary';
                            if ($status_tugas == 'proses') $badge_tugas = 'bg-primary';
                            if ($status_tugas == 'selesai') $badge_tugas = 'bg-success';
                            echo "<span class='badge $badge_tugas'>$status_tugas</span>";
                        ?>
                    </td>
                    <td>
                        <?php if (!$is_task_done): ?>
                            <a href="dashboard.php?edit_task=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="dashboard.php?delete_task_pm=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>