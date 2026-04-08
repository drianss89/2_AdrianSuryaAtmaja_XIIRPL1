<?php 
require_once '../config/koneksi.php';
require_once '../middleware/auth.php';

// Cek apakah yang login adalah admin
require_once '../middleware/auth.php';
checkLogin('admin');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Parkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4 d-none d-md-block" style="background: white; min-height: 100vh; border-right: 1px solid #ddd;">
            <h4 class="fw-bold mb-5 mt-2">APLIKASI PARKIR</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/parkir/auth/logout.php">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </li>
                
            </ul>
        </div>
        <div class="col-md-10 p-5 bg-light" style="min-height: 100vh;">
            
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold align-items-center">DASHBOARD ADMIN</h2>
                <div class="d-flex align-items-center">
                    <div class="profile-text text-end me-3">
                        <span class="d-block fw-bold text-uppercase"><?php echo $_SESSION['nama']; ?></span>
                        <small class="text-muted">Administrator</small>
                    </div>
                    <div class="bg-primary rounded-circle" style="width: 45px; height: 45px;"></div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <a href="user/index.php" class="menu-card">
                        <i class="bi bi-people-fill"></i>
                        <span>DATA USER</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="area/index.php" class="menu-card">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>AREA PARKIR</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="tarif/index.php" class="menu-card">
                        <i class="bi bi-cash-stack"></i>
                        <span>TARIF PARKIR</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="kendaraan/index.php" class="menu-card">
                        <i class="bi bi-car-front-fill"></i>
                        <span>DATA KENDARAAN</span>
                    </a>
                </div>
            </div>

            <div class="mt-5">
                <h5 class="fw-bold mb-3 text-muted">Aktivitas Terakhir</h5>
                <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Petugas</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil log aktivitas terbaru, join dengan tabel user untuk dapat nama petugas
                                $log_query = mysqli_query($conn, "SELECT log_aktivitas.*, user.nama, user.role 
                                                                FROM log_aktivitas 
                                                                JOIN user ON log_aktivitas.id_user = user.id_user 
                                                                ORDER BY log_aktivitas.waktu DESC 
                                                                LIMIT 5");
                                
                                if(mysqli_num_rows($log_query) > 0):
                                    while($row = mysqli_fetch_assoc($log_query)):
                                ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo $row['nama']; ?></span>
                                        <span class="badge <?php echo ($row['role'] == 'admin') ? 'bg-danger' : 'bg-primary'; ?>" style="font-size: 0.6rem;">
                                            <?php echo strtoupper($row['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="<?php echo ($row['role'] == 'admin') ? 'text-danger fw-medium' : ''; ?>">
                                            <?php echo $row['aktivitas']; ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small"><?php echo date('H:i', strtotime($row['waktu'])); ?></td>
                                </tr>
                                <?php 
                                    endwhile; 
                                else: 
                                ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bi bi-info-circle me-2"></i> Belum ada aktivitas petugas hari ini.
                                    </td>
                                </tr>
                                <?php endif; ?>
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