<?php 
require_once '../../config/koneksi.php';
if ($_POST) {
    $jenis = $_POST['jenis_kendaraan'];
    $biaya = $_POST['biaya'];
    mysqli_query($conn, "INSERT INTO tarif (jenis_kendaraan, tarif_per_jam) VALUES ('$jenis', '$biaya')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/parkir-app/assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 500px; border-radius: 20px;">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Tambah Tarif</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">JENIS KENDARAAN</label>
                        <select name="jenis_kendaraan" class="form-select form-control-custom" required>
                            <option value="Mobil">Mobil</option>
                            <option value="Motor">Motor</option>
                            <option value="Truk/Bus">Truk/Bus</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold">BIAYA PER JAM (RP)</label>
                        <input type="number" name="biaya" class="form-control form-control-custom" placeholder="Contoh: 5000" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3 fw-bold" style="border-radius: 12px;">SIMPAN TARIF</button>
                    <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>