<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

if (isset($_POST['update_tarif'])) {
    $jenis = $_POST['jenis_kendaraan'];
    $harga = $_POST['biaya'];
    
    tulis_log($conn, $_SESSION['id_user'], "Mengubah tarif $jenis menjadi Rp " . number_format($harga));
    // Lanjutkan query update...
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tarif Parkir - APLIKASI PARKIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="http://localhost/parkir-app/assets/css/style.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4 d-none d-md-block" style="background: white; min-height: 100vh; border-right: 1px solid #ddd;">
            <h4 class="fw-bold mb-5 mt-2 text-primary">APLIKASI PARKIR</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a class="nav-link text-muted" href="../dashboard.php"><i class="bi bi-house-door me-2"></i> Dashboard</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-muted" href="../user/index.php"><i class="bi bi-people me-2"></i> Data User</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-muted" href="../area/index.php"><i class="bi bi-geo-alt me-2"></i> Area Parkir</a></li>
                <li class="nav-item mb-2"><a class="nav-link active fw-bold text-dark" href="index.php"><i class="bi bi-cash-stack me-2"></i> Tarif Parkir</a></li>
                <li class="nav-item mb-2"><a class="nav-link text-muted" href="../kendaraan/index.php"><i class="bi bi-car-front me-2"></i> Data Kendaraan</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="../../auth/logout.php"><i class="bi bi-box-arrow-left me-2"></i> Logout</a></li>
            </ul>
        </div>

        <div class="col-md-10 p-5 bg-light">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Tarif Parkir</h2>
                <a href="tambah.php" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">Tambah Tarif</a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Kendaraan</th>
                                <th>Tarif per Jam</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($conn, "SELECT * FROM tarif ORDER BY jenis_kendaraan ASC");
                            while($row = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-uppercase"><?= $row['jenis_kendaraan']; ?></td>
                                <td class="text-success fw-bold">Rp <?= number_format($row['tarif_per_jam'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $row['id_tarif']; ?>" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil-square"></i></a>
                                    <a href="hapus.php?id=<?= $row['id_tarif']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tarif ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>