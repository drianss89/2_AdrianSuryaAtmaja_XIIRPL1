<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

// 1. Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id'");
$data = mysqli_fetch_assoc($query);

// 2. Proses jika tombol simpan ditekan
if ($_POST) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    $sql = "UPDATE user SET 
            nama = '$nama', 
            username = '$username', 
            password = '$password', 
            role = '$role' 
            WHERE id_user = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

include '../../layout/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
                <div class="d-flex align-items-center mb-4">
                    <a href="index.php" class="text-dark me-3"><i class="bi bi-arrow-left fs-4"></i></a>
                    <h4 class="fw-bold m-0">Edit User</h4>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-custom" 
                               value="<?= $data['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Username</label>
                        <input type="text" name="username" class="form-control form-control-custom" 
                               value="<?= $data['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                        <input type="text" name="password" class="form-control form-control-custom" 
                               value="<?= $data['password']; ?>" required>
                        <small class="text-info">*Password ditampilkan dalam plain text</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Role</label>
                        <select name="role" class="form-select form-control-custom">
                            <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="petugas" <?= ($data['role'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                            <option value="owner" <?= ($data['role'] == 'owner') ? 'selected' : ''; ?>>Owner</option>
                        </select>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 p-3 fw-bold" style="border-radius: 12px;">UPDATE DATA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../layout/footer.php'; ?>