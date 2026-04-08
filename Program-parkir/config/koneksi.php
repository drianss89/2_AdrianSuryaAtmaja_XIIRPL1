<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_parkir";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
define('BASE_URL', 'http://localhost/parkir-app/');

function tulis_log($conn, $id_user, $isi_aktivitas) {
    $waktu = date("Y-m-d H:i:s");
    $aktivitas_safe = mysqli_real_escape_string($conn, $isi_aktivitas);
    
    // Pastikan nama kolom di bawah ini adalah 'aktivitas' bukan 'aksi'
    $query = "INSERT INTO log_aktivitas (id_user, aktivitas, waktu) 
              VALUES ('$id_user', '$aktivitas_safe', '$waktu')";
              
    return mysqli_query($conn, $query);
}