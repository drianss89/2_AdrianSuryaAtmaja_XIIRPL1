<?php 
require_once '../config/koneksi.php'; 

// Jika sudah login, redirect ke dashboard masing-masing
if (isset($_SESSION['role'])) {
    header("Location: ../" . $_SESSION['role'] . "/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Parkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div class="login-container px-4">
        <h1 class="login-title">LOGIN</h1>
        
        <form action="proses_login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control form-control-custom" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-custom" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn btn-masuk">MASUK</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>