<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';

$id_p = $_GET['id_p'];
$id_a = $_GET['id_a'];
$waktu_keluar = date("Y-m-d H:i:s");

// 1. Ambil data parkir & tarif
$query = mysqli_query($conn, "SELECT t.*, k.*, a.nama_area, tr.tarif_per_jam as harga_per_jam 
    FROM transaksi t 
    JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan 
    JOIN area_parkir a ON t.id_area = a.id_area
    JOIN tarif tr ON k.jenis_kendaraan = tr.jenis_kendaraan
    WHERE t.id_parkir = '$id_p'");
$data = mysqli_fetch_assoc($query);

// 2. Hitung Durasi & Biaya
$masuk = new DateTime($data['waktu_masuk']);
$keluar = new DateTime($waktu_keluar);
$diff = $masuk->diff($keluar);
$durasi_jam = $diff->h + ($diff->days * 24); 
if($durasi_jam == 0) $durasi_jam = 1; // Minimal bayar 1 jam

$total_bayar = $durasi_jam * $data['harga_per_jam'];


mysqli_query($conn, "UPDATE transaksi SET 
    status = 'keluar', 
    waktu_keluar = '$waktu_keluar', 
    durasi = '$durasi_jam Jam', 
    total_bayar = '$total_bayar' 
    WHERE id_parkir = '$id_p'");

mysqli_query($conn, "UPDATE area_parkir SET terisi = terisi - 1 WHERE id_area = '$id_a'");

tulis_log($conn, $_SESSION['id_user'], "Menyelesaikan transaksi & Cetak Struk ID: $id_p");


?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .struk-box { border: 1px solid #000; padding: 30px; margin: 0 auto; max-width: 400px; font-family: monospace; }
    </style>
</head>
<body class="bg-light p-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-4">TRANSAKSI</h1>
        
        <div class="struk-box bg-white mb-4">
            <h5 class="fw-bold">STRUK</h5>
            <hr>
            <div class="text-start">
                <p>Waktu Masuk : <?= $data['waktu_masuk'] ?></p>
                <p>Waktu Keluar: <?= $waktu_keluar ?></p>
                <p>Durasi      : <?= $durasi_jam ?> Jam</p>
                <p>Tarif       : Rp <?= number_format($data['harga_per_jam']) ?> /jam</p>
                <p class="fw-bold">Biaya       : Rp <?= number_format($total_bayar) ?></p>
                <p>Area        : <?= $data['nama_area'] ?></p>
                <p>Petugas     : <?= $_SESSION['nama'] ?></p>
            </div>
            <hr>
            <p>terimakasih</p>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="../dashboard.php" class="btn btn-success px-5 rounded-pill">BERANDA</a>
            <button onclick="window.print()" class="btn btn-primary px-5 rounded-pill">CETAK STRUK</button>
        </div>
    </div>
</body>
</html>