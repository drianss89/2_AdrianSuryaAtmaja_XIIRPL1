<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tarif WHERE id_tarif = '$id'");
$data = mysqli_fetch_assoc($query);

if ($_POST) {
    $jenis = $_POST['jenis_kendaraan'];
    $tarif_per_jam = $_POST['tarif_per_jam'];

    $update = mysqli_query($conn, "UPDATE tarif SET jenis_kendaraan='$jenis', tarif_per_jam='$tarif_per_jam' WHERE id_tarif='$id'");
    if($update) {
        header("Location: index.php");
    }
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
                <h4 class="fw-bold mb-4">Edit Tarif</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">JENIS KENDARAAN</label>
                        <select name="jenis_kendaraan" class="form-select form-control-custom">
                            <option value="Mobil" <?= $data['jenis_kendaraan'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                            <option value="Motor" <?= $data['jenis_kendaraan'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
                            <option value="Truk/Bus" <?= $data['jenis_kendaraan'] == 'Truk/Bus' ? 'selected' : '' ?>>Truk/Bus</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold">BIAYA PER JAM (RP)</label>
                        <input type="number" name="tarif_per_jam" class="form-control form-control-custom" value="<?= $data['tarif_per_jam'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3 fw-bold" style="border-radius: 12px;">UPDATE TARIF</button>
                    <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>