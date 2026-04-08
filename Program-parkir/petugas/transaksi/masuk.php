<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('petugas');

if ($_POST) {
    $plat = mysqli_real_escape_string($conn, $_POST['plat_nomor']);
    $id_area = $_POST['id_area'];
    $waktu_masuk = date("Y-m-d H:i:s");

    // --- LOGIKA CEK DOUBLE ENTRY ---
    // Kita cek di tabel transaksi, apakah plat ini punya status 'masuk' yang belum 'keluar'
    $cek_status = mysqli_query($conn, "SELECT t.id_parkir 
                                       FROM transaksi t
                                       JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan
                                       WHERE k.plat_nomor = '$plat' AND t.status = 'masuk'");

    if (mysqli_num_rows($cek_status) > 0) {
        // Jika ditemukan transaksi yang masih berstatus 'masuk', blokir akses!
        echo "<script>
                alert('Gagal! Kendaraan dengan plat $plat terdeteksi MASIH berada di dalam area parkir.');
                window.location='masuk.php';
              </script>";
        exit; // Hentikan proses eksekusi kode di bawahnya
    }
    // --- END LOGIKA CEK ---

    // 1. Jika lolos cek, baru cari/simpan ke Master Kendaraan
    $cek_master = mysqli_query($conn, "SELECT id_kendaraan FROM kendaraan WHERE plat_nomor = '$plat'");
    
    if (mysqli_num_rows($cek_master) > 0) {
        $data_k = mysqli_fetch_assoc($cek_master);
        $id_kendaraan = $data_k['id_kendaraan'];
    } else {
        $pemilik = !empty($_POST['pemilik']) ? $_POST['pemilik'] : ' ';
        $merk    = $_POST['merk'];
        $warna   = $_POST['warna'];
        $jenis   = $_POST['jenis_kendaraan'];
        
        mysqli_query($conn, "INSERT INTO kendaraan (plat_nomor, pemilik, merk, warna, jenis_kendaraan) 
                             VALUES ('$plat', '$pemilik', '$merk', '$warna', '$jenis')");
        $id_kendaraan = mysqli_insert_id($conn);
    }

    // 2. Simpan Transaksi Baru
    $sql_transaksi = "INSERT INTO transaksi (id_kendaraan, id_area, waktu_masuk, status) 
                      VALUES ('$id_kendaraan', '$id_area', '$waktu_masuk', 'masuk')";
    
    if (mysqli_query($conn, $sql_transaksi)) {
        tulis_log($conn, $_SESSION['id_user'], "Menginput kendaraan masuk: $plat");
        mysqli_query($conn, "UPDATE area_parkir SET terisi = terisi + 1 WHERE id_area = '$id_area'");
        echo "<script>alert('Kendaraan Berhasil Masuk!'); window.location='keluar.php';</script>";
    }
}

// Untuk Dropdown
$areas = mysqli_query($conn, "SELECT * FROM area_parkir WHERE terisi < kapasitas");
$tarifs = mysqli_query($conn, "SELECT * FROM tarif");
$pemilik = !empty($_POST['pemilik']) ? mysqli_real_escape_string($conn, $_POST['pemilik']) : ' ';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 500px; border-radius: 15px;">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4"><i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Kendaraan Masuk</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">NOMOR PLAT</label>
                        <input type="text" name="plat_nomor" class="form-control text-uppercase" placeholder="B 1234 ABC" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">PEMILIK</label>
                        <input type="text" name="pemilik" class="form-control" placeholder="Nama Pemilik (OPSIONAL)">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small fw-bold">MERK</label>
                            <input type="text" name="merk" class="form-control" placeholder="Honda/Toyota">
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold">WARNA</label>
                            <input type="text" name="warna" class="form-control" placeholder="Hitam/Putih">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">JENIS (TARIF)</label>
                        <select name="jenis_kendaraan" class="form-select">
                            <?php while($t = mysqli_fetch_assoc($tarifs)): ?>
                                <option value="<?= $t['jenis_kendaraan'] ?>"><?= $t['jenis_kendaraan'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold">PILIH AREA PARKIR</label>
                        <select name="id_area" class="form-select" required>
                            <?php while($a = mysqli_fetch_assoc($areas)): ?>
                                <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?> (Sisa: <?= $a['kapasitas'] - $a['terisi'] ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold p-3" style="border-radius: 10px;">PROSES MASUK</button>
                    <a href="../dashboard.php" class="btn btn-link w-100 text-muted mt-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>