<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data kendaraan berdasarkan ID
$query_data = mysqli_query($conn, "SELECT * FROM kendaraan WHERE id_kendaraan = '$id'");
$data = mysqli_fetch_assoc($query_data);

// 3. Jika data tidak ditemukan, balikkan ke index
if (!$data) {
    header("Location: index.php");
    exit;
}

// 4. Proses Update saat tombol diklik
if ($_POST) {
    $plat = $_POST['plat_nomor'];
    $pemilik = $_POST['pemilik'];
    $merk = $_POST['merk'];
    $warna = $_POST['warna'];
    $jenis = $_POST['jenis_kendaraan'];

    $update = mysqli_query($conn, "UPDATE kendaraan SET 
        plat_nomor = '$plat', 
        pemilik = '$pemilik', 
        merk = '$merk', 
        warna = '$warna', 
        jenis_kendaraan = '$jenis' 
        WHERE id_kendaraan = '$id'");

    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal mengupdate data!";
    }
}

// Ambil data tarif untuk dropdown jenis
$data_tarif = mysqli_query($conn, "SELECT * FROM tarif");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kendaraan - APLIKASI PARKIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/parkir-app/assets/css/style.css">
</head>
<body class="bg-light p-5">

    <div class="container">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px; border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <a href="index.php" class="btn btn-sm btn-light me-3" style="border-radius: 50%;"><i class="bi bi-arrow-left"></i></a>
                    <h4 class="fw-bold m-0">Edit Data Kendaraan</h4>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">PLAT NOMOR</label>
                        <input type="text" name="plat_nomor" class="form-control form-control-lg" 
                               value="<?= $data['plat_nomor'] ?>" style="text-transform: uppercase;" required>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-muted">NAMA PEMILIK</label>
                        <input type="text" name="pemilik" class="form-control" 
                               value="<?= $data['pemilik'] ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted">MERK KENDARAAN</label>
                            <input type="text" name="merk" class="form-control" 
                                   value="<?= $data['merk'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted">WARNA</label>
                            <input type="text" name="warna" class="form-control" 
                                   value="<?= $data['warna'] ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted">JENIS KENDARAAN</label>
                        <select name="jenis_kendaraan" class="form-select">
                            <?php while($t = mysqli_fetch_assoc($data_tarif)): ?>
                                <option value="<?= $t['jenis_kendaraan'] ?>" 
                                    <?= ($data['jenis_kendaraan'] == $t['jenis_kendaraan']) ? 'selected' : '' ?>>
                                    <?= $t['jenis_kendaraan'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary p-3 fw-bold" style="border-radius: 12px;">
                            SIMPAN PERUBAHAN
                        </button>
                        <a href="index.php" class="btn btn-link text-muted mt-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>