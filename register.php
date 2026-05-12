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
    <title>Daftar - Risk Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="logo">
                    <i class="bi bi-shield-exclamation"></i>
                    <span>RMS</span>
                </div>
                <h1>Buat Akun Baru</h1>
                <p>Bergabunglah dengan sistem manajemen risiko terpadu</p>
            </div>

            <form action="register-process.php" method="post" class="register-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="text" id="username" name="username" placeholder="Pilih username unik Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password yang kuat" required>
                    </div>
                </div>

                <div class="role-selection">
                    <label>Pilih Peran Anda</label>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" id="user" name="role" value="User" checked>
                            <label for="user" class="role-label">
                                <i class="bi bi-person-check"></i>
                                <span class="role-title">User</span>
                                <span class="role-desc">Lapor risiko dan dapatkan solusi</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="admin" name="role" value="Admin">
                            <label for="admin" class="role-label">
                                <i class="bi bi-shield-check"></i>
                                <span class="role-title">Admin</span>
                                <span class="role-desc">Validasi dan berikan solusi</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="info-message" class="info-message">
                    <i class="bi bi-info-circle"></i>
                    <span id="message-text">User memberikan keluhan dan masalah yang sedang berlangsung.</span>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="login-link">
                <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
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
                <h3>Bergabunglah Sekarang</h3>
                <ul>
                    <li><i class="bi bi-check-circle"></i> Kelola risiko dengan efisien</li>
                    <li><i class="bi bi-check-circle"></i> Dapatkan solusi dari expert</li>
                    <li><i class="bi bi-check-circle"></i> Monitor progress real-time</li>
                    <li><i class="bi bi-check-circle"></i> Kolaborasi dengan tim</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const userRadio = document.getElementById('user');
        const adminRadio = document.getElementById('admin');
        const messageText = document.getElementById('message-text');

        function updateMessage() {
            if (userRadio.checked) {
                messageText.textContent = "User memberikan keluhan dan masalah yang sedang berlangsung.";
            } else if (adminRadio.checked) {
                messageText.textContent = "Admin membantu mencari solusi dan pencegahan masalah yang diajukan oleh user.";
            }
        }

        userRadio.addEventListener('change', updateMessage);
        adminRadio.addEventListener('change', updateMessage);
    </script>
</body>
</html>
