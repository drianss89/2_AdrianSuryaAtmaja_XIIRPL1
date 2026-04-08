<?php
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

$id = $_GET['id']; // ID Area

// 1. Cek apakah area ini pernah digunakan dalam transaksi
$cek_penggunaan = mysqli_query($conn, "SELECT id_parkir FROM transaksi WHERE id_area = '$id' LIMIT 1");

if (mysqli_num_rows($cek_penggunaan) > 0) {
    // Jika area sudah pernah dipakai transaksi, BLOKIR penghapusan
    echo "<script>
            alert('Gagal Menghapus! Area ini memiliki riwayat transaksi aktif atau lampau. Jika area tidak digunakan lagi, sebaiknya ubah kapasitasnya menjadi 0 daripada menghapusnya.');
            window.location='index.php';
          </script>";
} else {
    // Jika area benar-benar baru dan belum pernah dipakai, baru boleh hapus
    $query = "DELETE FROM area_parkir WHERE id_area = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Area parkir berhasil dihapus.');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan database saat mencoba menghapus.');
                window.location='index.php';
              </script>";
    }
}
?>