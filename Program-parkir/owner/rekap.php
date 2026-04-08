<?php 
require_once '../config/koneksi.php';

// Ambil tanggal dari filter (jika ada)
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

// Query dasar
$query_str = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, a.nama_area 
              FROM transaksi t
              JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan
              JOIN area_parkir a ON t.id_area = a.id_area
              WHERE t.status = 'keluar'";

// Jika filter tanggal diisi, tambahkan kondisi WHERE
if ($tgl_mulai != '' && $tgl_selesai != '') {
    $query_str .= " AND DATE(t.waktu_keluar) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

$query_str .= " ORDER BY t.waktu_keluar DESC";
$query = mysqli_query($conn, $query_str);

// Hitung total pendapatan dari hasil filter
$total_pendapatan = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary"><i class="bi bi-file-earmark-text me-2"></i>Laporan Transaksi</h4>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="rekap.php" class="btn btn-outline-secondary w-100">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="ps-3">No.</th>
                            <th>Plat Nomor</th>
                            <th>Area</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Durasi</th>
                            <th class="text-end pe-3">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($query) > 0):
                            while($row = mysqli_fetch_assoc($query)): 
                                $total_pendapatan += $row['total_bayar'];
                        ?>
                        <tr>
                            <td class="ps-3"><?= $no++ ?></td>
                            <td>
                                <span class="fw-bold text-uppercase"><?= $row['plat_nomor'] ?></span>
                                <div class="text-muted" style="font-size: 0.75rem;"><?= $row['jenis_kendaraan'] ?></div>
                            </td>
                            <td><?= $row['nama_area'] ?></td>
                            <td class="small"><?= date('d M Y, H:i', strtotime($row['waktu_masuk'])) ?></td>
                            <td class="small"><?= date('d M Y, H:i', strtotime($row['waktu_keluar'])) ?></td>
                            <td><?= $row['durasi'] ?></td>
                            <td class="text-end pe-3 fw-bold text-success">Rp <?= number_format($row['total_bayar']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <tr class="table-light">
                            <td colspan="6" class="text-end fw-bold">TOTAL PENDAPATAN :</td>
                            <td class="text-end pe-3 fw-bold text-primary" style="font-size: 1.1rem;">
                                Rp <?= number_format($total_pendapatan) ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan untuk periode ini.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>