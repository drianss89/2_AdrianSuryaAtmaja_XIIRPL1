<?php
function tulis_log($conn, $id_user, $isi_aktivitas) {
    $waktu = date("Y-m-d H:i:s");
    $aktivitas_safe = mysqli_real_escape_string($conn, $isi_aktivitas);

    $query = "INSERT INTO log_aktivitas (id_user, aktivitas, waktu)
              VALUES ('$id_user', '$aktivitas_safe', '$waktu')";

    return mysqli_query($conn, $query);
}
?>