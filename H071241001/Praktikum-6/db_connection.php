<?php
$hostname = "localhost";
$username = "root";
$password = ""; // Sesuaikan jika XAMPP Anda ada password
$database = "db_manajemen_proyek";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>