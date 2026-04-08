<?php 
require_once '../config/koneksi.php';
// Asumsi: status login owner sudah dicek di middleware

// 1. Total Pendapatan Hari Ini
$hari_ini = date('Y-m-d');
$q_pendapatan = mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM transaksi WHERE DATE(waktu_keluar) = '$hari_ini' AND status = 'keluar'");
$total_duit = mysqli_fetch_assoc($q_pendapatan)['total'] ?? 0;

// 2. Total Kendaraan Masuk Hari Ini
$q_kendaraan = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM transaksi WHERE DATE(waktu_masuk) = '$hari_ini'");
$total_mobil = mysqli_fetch_assoc($q_kendaraan)['jumlah'];

// 3. Kendaraan yang MASIH Parkir (Belum Bayar)
$q_aktif = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM transaksi WHERE status = 'masuk'");
$mobil_aktif = mysqli_fetch_assoc($q_aktif)['jumlah'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Laporan Owner</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3">
                    <div class="card-body">
                        <h6 class="text-uppercase small">Pendapatan Hari Ini</h6>
                        <h2 class="fw-bold">Rp <?= number_format($total_duit) ?></h2>
                        <i class="bi bi-cash-stack position-absolute top-0 end-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white p-3">
                    <div class="card-body">
                        <h6 class="text-uppercase small">Total Kendaraan Hari Ini</h6>
                        <h2 class="fw-bold"><?= $total_mobil ?> Unit</h2>
                        <i class="bi bi-car-front-fill position-absolute top-0 end-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-warning text-dark p-3">
                    <div class="card-body">
                        <h6 class="text-uppercase small">Kendaraan di Lokasi (SAAT INI)</h6>
                        <h2 class="fw-bold"><?= $mobil_aktif ?> Unit</h2>
                        <i class="bi bi-p-square-fill position-absolute top-0 end-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-block">
            <a href="rekap.php" class="btn btn-dark px-4 shadow-sm">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Lihat Laporan Detail
            </a>
            <a href="/parkir/auth/logout.php" class="btn btn-outline-danger px-4 shadow-sm">Logout</a>
        </div>
    </div>
</body>
</html>