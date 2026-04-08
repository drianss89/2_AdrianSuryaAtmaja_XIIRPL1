<?php
require_once '../../config/koneksi.php';

$id = $_GET['id'];

// 1. Cek apakah kendaraan ini pernah punya riwayat transaksi
$cek_transaksi = mysqli_query($conn, "SELECT id_parkir FROM transaksi WHERE id_kendaraan = '$id' LIMIT 1");

if (mysqli_num_rows($cek_transaksi) > 0) {
    // Jika ada transaksi, JANGAN HAPUS, tampilkan alert
    echo "<script>
            alert('Gagal Menghapus! Kendaraan ini memiliki riwayat transaksi dalam sistem. Data yang memiliki riwayat keuangan tidak boleh dihapus demi keamanan audit.');
            window.location='index.php';
          </script>";
} else {
    // Jika tidak ada transaksi (mungkin salah input baru), baru boleh hapus
    $query = "DELETE FROM kendaraan WHERE id_kendaraan = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data kendaraan berhasil dihapus.');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan database.');
                window.location='index.php';
              </script>";
    }
}
?>