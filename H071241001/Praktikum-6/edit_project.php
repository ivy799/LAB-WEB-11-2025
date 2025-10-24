<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: index.php");
    exit();
}
$manager_id = $_SESSION['user_id'];
if (!isset($_GET['id'])) {
    header("Location: manage_projects.php");
    exit();
}
$project_id = $_GET['id'];
$sql = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $project_id, $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) != 1) {
    header("Location: manage_projects.php");
    exit();
}
$project = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
        input, textarea, button { display: block; width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; }
        .back-link { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="manage_projects.php" class="back-link">&larr; Back to Projects</a>
        <h1>Edit Project: <?php echo htmlspecialchars($project['nama_proyek']); ?></h1>
        <form action="process_edit_project.php" method="post">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <label for="nama_proyek">Project Name:</label>
            <input type="text" name="nama_proyek" value="<?php echo htmlspecialchars($project['nama_proyek']); ?>" required>
            <label for="deskripsi">Description:</label>
            <textarea name="deskripsi" rows="4"><?php echo htmlspecialchars($project['deskripsi']); ?></textarea>
            <label for="tanggal_mulai">Start Date:</label>
            <input type="date" name="tanggal_mulai" value="<?php echo $project['tanggal_mulai']; ?>" required>
            <label for="tanggal_selesai">End Date:</label>
            <input type="date" name="tanggal_selesai" value="<?php echo $project['tanggal_selesai']; ?>" required>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>