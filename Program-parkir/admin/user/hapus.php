<?php
require_once '../../config/koneksi.php';

$id = $_GET['id'];

// Langkah 1: Hapus riwayat aktivitas user tersebut agar relasi terputus
mysqli_query($conn, "DELETE FROM log_aktivitas WHERE id_user = '$id'");

// Langkah 2: Baru hapus usernya (Baris 7 yang diperbaiki)
$query = "DELETE FROM user WHERE id_user = '$id'";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('User dan riwayat aktivitasnya berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>