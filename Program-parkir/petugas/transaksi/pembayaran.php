<?php 
require_once '../../config/koneksi.php';
$id_p = $_GET['id_p'];
$id_a = $_GET['id_a'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .full-screen { height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; }
        .box { border: 1px solid #ccc; border-radius: 15px; padding: 100px; width: 80%; }
    </style>
</head>
<body class="bg-light">
    <div class="container full-screen">
        <div class="box bg-white shadow-sm">
            <h1 class="fw-bold mb-5">TRANSAKSI</h1>
            <h2 class="text-uppercase mb-5" style="letter-spacing: 5px;">MENUNGGU PEMBAYARAN</h2>
            
            <a href="struk.php?id_p=<?= $id_p ?>&id_a=<?= $id_a ?>" class="btn btn-success btn-lg px-5 rounded-pill">SELESAI</a>
        </div>
    </div>
</body>
</html>