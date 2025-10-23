<?php include '../includes/header.php'; 

if ($_SESSION['role'] != 'superadmin') {
    header("Location: ../auth/login.php");
    exit();
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Super Admin</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Pengguna</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as total FROM users WHERE role != 'superadmin'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <h2><?php echo $row['total']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Proyek</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as total FROM projects";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <h2><?php echo $row['total']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-project-diagram fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Tugas</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as total FROM tasks";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <h2><?php echo $row['total']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Tugas</h5>
            </div>
            <div class="card-body">
                <?php
                $status_sql = "SELECT status, COUNT(*) as count FROM tasks GROUP BY status";
                $status_result = mysqli_query($conn, $status_sql);
                while ($status = mysqli_fetch_assoc($status_result)):
                    $badge_color = '';
                    switch($status['status']) {
                        case 'selesai': $badge_color = 'success'; break;
                        case 'proses': $badge_color = 'warning'; break;
                        default: $badge_color = 'secondary';
                    }
                ?>
                    <div class="mb-2">
                        <span class="badge bg-<?php echo $badge_color; ?>">
                            <?php echo ucfirst($status['status']); ?>
                        </span>
                        : <?php echo $status['count']; ?> tugas
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>