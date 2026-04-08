<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('petugas');

// PROSES KELUAR: Jika tombol keluar diklik
if (isset($_GET['id_p'])) {
    $id_p = $_GET['id_p'];
    $id_a = $_GET['id_a'];
    $waktu_keluar = date("Y-m-d H:i:s");

    // 1. Selesaikan Transaksi di Tabel Transaksi (Cari berdasarkan id_parkir)
    $update = mysqli_query($conn, "UPDATE transaksi SET 
                                status = 'keluar', 
                                waktu_keluar = '$waktu_keluar' 
                                WHERE id_parkir = '$id_p'");
    
    if ($update) {
        // 2. Kembalikan Slot di Area Parkir
        mysqli_query($conn, "UPDATE area_parkir SET terisi = terisi - 1 WHERE id_area = '$id_a'");
        header("Location: keluar.php");
        exit;
    }
}

// TAMPILKAN DATA: Ambil dari transaksi yang sedang 'parkir'
$query_list = "SELECT 
                transaksi.id_parkir, 
                transaksi.id_area, 
                kendaraan.plat_nomor, 
                kendaraan.pemilik, 
                area_parkir.nama_area, 
                transaksi.waktu_masuk 
               FROM transaksi 
               JOIN kendaraan ON transaksi.id_kendaraan = kendaraan.id_kendaraan 
               JOIN area_parkir ON transaksi.id_area = area_parkir.id_area 
               WHERE transaksi.status = 'masuk'";

$list = mysqli_query($conn, $query_list);

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <h4 class="fw-bold mb-4">Daftar Kendaraan Aktif (Dalam Parkiran)</h4>
        <a href="../dashboard.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Plat Nomor</th>
                            <th>Pemilik</th>
                            <th>Lokasi Area</th>
                            <th>Jam Masuk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($list)): ?>
                        <tr>
                            <td class="fw-bold"><?= $row['plat_nomor'] ?></td>
                            <td><?= !empty($row['pemilik']) ? $row['pemilik'] : ' ' ?></td>
                            <td><span class="badge bg-primary"><?= $row['nama_area'] ?></span></td>
                            <td><?= date('H:i', strtotime($row['waktu_masuk'])) ?></td>
                            <td class="text-center">
                                <a href="pembayaran.php?id_p=<?= $row['id_parkir'] ?>&id_a=<?= $row['id_area'] ?>" 
                                class="btn btn-success btn-sm px-3">Lakukan Transaksi</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(mysqli_num_rows($list) == 0): ?>
                            <tr><td colspan="5" class="text-center p-5 text-muted">Belum ada kendaraan yang parkir.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>