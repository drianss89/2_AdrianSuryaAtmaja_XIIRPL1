<?php
function hitungTotalBayar($waktu_masuk, $waktu_keluar, $tarif_per_jam) {
    $waktu_masuk_timestamp = strtotime($waktu_masuk);
    $waktu_keluar_timestamp = strtotime($waktu_keluar);

    $durasi_detik = $waktu_keluar_timestamp - $waktu_masuk_timestamp;
    $durasi_jam = ceil($durasi_detik / 3600); // Bulatkan ke atas

    $total = $durasi_jam * $tarif_per_jam;

    return [
        'durasi' => $durasi_jam . ' jam',
        'total' => $total
    ];
}
?>