<?php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root'; 
$DB_PASS = '';     
$DB_NAME = 'db_manajemen_proyek';

$koneksi = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

?>