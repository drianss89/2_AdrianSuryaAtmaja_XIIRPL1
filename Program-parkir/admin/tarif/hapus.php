<?php
require_once '../../config/koneksi.php';
require_once '../../middleware/auth.php';
checkLogin('admin');

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tarif WHERE id_tarif = '$id'");
header("Location: index.php");
?>