<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan - APLIKASI PARKIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="http://localhost/parkir-app/assets/css/style.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4 d-none d-md-block" style="background: white; min-height: 100vh; border-right: 1px solid #ddd;">
            <h4 class="fw-bold mb-5 mt-2 text-primary">APLIKASI PARKIR</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-muted" href="../dashboard.php">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-muted" href="../user/index.php">
                        <i class="bi bi-people me-2"></i> Data User
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-muted" href="../area/index.php">
                        <i class="bi bi-geo-alt me-2"></i> Area Parkir
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-muted" href="../tarif/index.php">
                        <i class="bi bi-cash-stack me-2"></i> Tarif Parkir
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active fw-bold text-dark" href="index.php">
                        <i class="bi bi-car-front me-2"></i> Data Kendaraan
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="../../auth/logout.php">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Data Kendaraan</h2>
                <a href="tambah.php" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-plus-lg"></i> Input Kendaraan
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Plat Nomor</th>
                                    <th>Pemilik</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Warna Kendaraan</th>
                                    <th>Merk Kendaraan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                // Query simpel sesuai analisa (hanya dari tabel kendaraan)
                                $query = mysqli_query($conn, "SELECT * FROM kendaraan");
                                
                                if(mysqli_num_rows($query) > 0) {
                                    while($row = mysqli_fetch_assoc($query)):
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="fw-bold text-uppercase"><?= $row['plat_nomor']; ?></td>
                                    <td><?= $row['pemilik']; ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark text-uppercase"><?= $row['jenis_kendaraan']; ?></span>
                                    </td>
                                    <td><?= $row['warna']; ?></td>
                                    <td><?= $row['merk']; ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-sm btn-warning text-white shadow-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Yakin hapus data kendaraan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted p-4'>Belum ada data kendaraan terparkir.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>