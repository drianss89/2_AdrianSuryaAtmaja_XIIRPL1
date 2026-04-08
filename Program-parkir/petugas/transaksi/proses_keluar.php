<?php
require_once '../../config/koneksi.php';
require_once '../../functions/hitung.php';

if ($_POST) {
    $id_parkir = $_POST['id_parkir'];
    $waktu_keluar = date('Y-m-d H:i:s');

    $query = mysqli_query($conn, "SELECT t.*, tr.tarif_per_jam 
                                  FROM transaksi t 
                                  JOIN tarif tr ON t.id_tarif = tr.id_tarif 
                                  WHERE t.id_parkir = '$id_parkir'");
    $data = mysqli_fetch_assoc($query);

    $hasil = hitungTotalBayar($data['waktu_masuk'], $waktu_keluar, $data['tarif_per_jam']);

    $durasi = $hasil['durasi'];
    $total = $hasil['total'];

    $sql = "UPDATE transaksi SET 
            waktu_keluar = '$waktu_keluar', 
            durasi = '$durasi', 
            total_bayar = '$total', 
            status = 'keluar' 
            WHERE id_parkir = '$id_parkir'";

    if (mysqli_query($conn, $sql)) {
        header("Location: selesai.php?id=$id_parkir");
    }
}