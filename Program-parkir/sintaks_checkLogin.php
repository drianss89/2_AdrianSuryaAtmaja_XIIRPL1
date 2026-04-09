<?php
function checkLogin($role_required = null) {
    if (!isset($_SESSION['id_user'])) {
        header("Location: " . BASE_URL . "auth/login.php");
        exit;
    }

    if ($role_required && $_SESSION['role'] !== $role_required) {
        die("Akses Ditolak: Anda tidak memiliki izin.");
    }
}
?>