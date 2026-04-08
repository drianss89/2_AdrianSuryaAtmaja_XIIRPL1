<?php 
require_once '../../config/koneksi.php';
if ($_POST) {
    $nama = $_POST['nama_area'];
    $kapasitas = $_POST['kapasitas'];
    mysqli_query($conn, "INSERT INTO area_parkir (nama_area, kapasitas) VALUES ('$nama', '$kapasitas')");
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
                <h4 class="fw-bold mb-4">Tambah Area Parkir</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">NAMA AREA</label>
                        <input type="text" name="nama_area" class="form-control form-control-custom" placeholder="Contoh: Basement A" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">KAPASITAS</label>
                        <input type="number" name="kapasitas" class="form-control form-control-custom" placeholder="Jumlah maksimal" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3 fw-bold shadow-sm" style="border-radius: 12px;">SIMPAN AREA</button>
                    <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>