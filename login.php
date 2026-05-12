<?php
    session_start();
    if(isset($_SESSION['login'])){
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Risk Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="logo">
                    <i class="bi bi-shield-exclamation"></i>
                    <span>RMS</span>
                </div>
                <h1>Masuk ke Akun</h1>
                <p>Kelola risiko bisnis Anda dengan lebih efisien</p>
            </div>

            <form action="login-process.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <button type="submit" name="login" class="submit-btn">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="signup-link">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>

            <div class="back-link">
                <a href="../index.php">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        <div class="illustration">
            <div class="gradient-box">
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
                <div class="floating-shape shape-3"></div>
            </div>
            <div class="info-box">
                <h3>Selamat Datang</h3>
                <p>Sistem manajemen risiko yang dirancang untuk membantu organisasi Anda mengidentifikasi dan mengatasi risiko dengan lebih efektif.</p>
            </div>
        </div>
    </div>
</body>
</html>