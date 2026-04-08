<?php 
require_once '../middleware/auth.php';
require_once '../config/koneksi.php';
checkLogin('petugas'); // Pastikan hanya petugas yang bisa akses

// Ambil data area untuk cek sisa slot
$query_area = mysqli_query($conn, "SELECT * FROM area_parkir");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold">PETUGAS PARKIR</span>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold text-dark">Status Area Parkir</h4>
            </div>
            <?php while($area = mysqli_fetch_assoc($query_area)): 
                $sisa = $area['kapasitas'] - $area['terisi'];
            ?>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted fw-bold"><?= strtoupper($area['nama_area']) ?></h6>
                        <h2 class="fw-bold <?= ($sisa > 0) ? 'text-success' : 'text-danger' ?>">
                            <?= $sisa ?> <small class="fs-6 text-muted">Slot Sisa</small>
                        </h2>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" style="width: <?= ($area['terisi']/$area['kapasitas'])*100 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="row text-center">
            <div class="col-md-6 mb-3">
                <a href="transaksi/masuk.php" class="card card-body border-0 shadow-sm p-5 text-decoration-none">
                    <i class="bi bi-box-arrow-in-right display-1 text-primary"></i>
                    <h3 class="fw-bold mt-3">KENDARAAN MASUK</h3>
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="transaksi/keluar.php" class="card card-body border-0 shadow-sm p-5 text-decoration-none">
                    <i class="bi bi-box-arrow-left display-1 text-danger"></i>
                    <h3 class="fw-bold mt-3">KENDARAAN KELUAR</h3>
                </a>
            </div>
        </div>
    </div>
</body>
</html>