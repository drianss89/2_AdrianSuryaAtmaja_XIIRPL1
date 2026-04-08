<?php 
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

if ($_POST) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Ingat: ini plain text sesuai request Anda
    $role = $_POST['role'];

    $sql = "INSERT INTO user (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    }
}
include '../../layout/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
                <h4 class="fw-bold mb-4">Tambah User Baru</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-custom" placeholder="Masukkan nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Username</label>
                        <input type="text" name="username" class="form-control form-control-custom" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Password</label>
                        <input type="password" name="password" class="form-control form-control-custom" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted">Role</label>
                        <select name="role" class="form-select form-control-custom">
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 p-3" style="border-radius: 12px;">SIMPAN</button>
                        <a href="index.php" class="btn btn-light w-100 p-3" style="border-radius: 12px;">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>