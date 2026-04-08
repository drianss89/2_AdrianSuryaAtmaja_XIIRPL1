<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM area_parkir WHERE id_area = '$id'");
$data = mysqli_fetch_assoc($query);

if ($_POST) {
    $nama = $_POST['nama_area'];
    $kapasitas = $_POST['kapasitas'];

    $update = mysqli_query($conn, "UPDATE area_parkir SET nama_area='$nama', kapasitas='$kapasitas' WHERE id_area='$id'");
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
                <h4 class="fw-bold mb-4">Edit Area Parkir</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">NAMA AREA</label>
                        <input type="text" name="nama_area" class="form-control form-control-custom" value="<?= $data['nama_area'] ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold">KAPASITAS TOTAL</label>
                        <input type="number" name="kapasitas" class="form-control form-control-custom" value="<?= $data['kapasitas'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3 fw-bold" style="border-radius: 12px;">UPDATE AREA</button>
                    <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>