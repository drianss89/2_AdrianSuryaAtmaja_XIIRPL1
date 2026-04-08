<?php 
require_once '../../config/koneksi.php';

if ($_POST) {
    $plat = $_POST['plat_nomor'];
    $pemilik = $_POST['pemilik'];
    $merk = $_POST['merk'];
    $warna = $_POST['warna'];
    $jenis = $_POST['jenis_kendaraan'];
    $id_area = $_POST['id_area']; 

    // Query sesuai analisa terbaru: Plat, Pemilik, Merk, Warna, Jenis
    $sql = "INSERT INTO kendaraan (plat_nomor, pemilik, merk, warna, jenis_kendaraan) 
            VALUES ('$plat', '$pemilik', '$merk', '$warna', '$jenis')";
    
    if (mysqli_query($conn, $sql)) {
        // Update manual slot di area parkir
        mysqli_query($conn, "UPDATE area_parkir SET terisi = terisi + 1 WHERE id_area = '$id_area'");
        header("Location: index.php");
    }
}

$data_tarif = mysqli_query($conn, "SELECT * FROM tarif");
$data_area = mysqli_query($conn, "SELECT * FROM area_parkir WHERE terisi < kapasitas");
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 500px; border-radius: 20px;">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Registrasi Kendaraan</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="small fw-bold">PLAT NOMOR</label>
                    <input type="text" name="plat_nomor" class="form-control" placeholder="B 1234 ABC" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">NAMA PEMILIK</label>
                    <input type="text" name="pemilik" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">MERK</label>
                        <input type="text" name="merk" class="form-control" placeholder="Contoh: Honda" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">WARNA</label>
                        <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">JENIS KENDARAAN</label>
                    <select name="jenis_kendaraan" class="form-select">
                        <?php while($t = mysqli_fetch_assoc($data_tarif)): ?>
                            <option value="<?= $t['jenis_kendaraan'] ?>"><?= $t['jenis_kendaraan'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 p-3 fw-bold" style="border-radius: 12px;">DAFTARKAN & MASUK</button>
                <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>