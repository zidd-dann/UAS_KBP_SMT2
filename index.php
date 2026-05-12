<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Management System - RMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <i class="bi bi-shield-exclamation"></i>
                <span>RMS</span>
            </div>
            <div class="navbar-menu">
                <?php if (isset($_SESSION['login'])): ?>
                    <span class="navbar-user">
                        <i class="bi bi-person-circle"></i>
                        Welcome, <?= $_SESSION['username'] ?? 'User' ?>
                    </span>
                    <a href="process/logout.php" class="navbar-btn logout-btn">Logout</a>
                <?php else: ?>
                    <a href="process/login.php" class="navbar-btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="gradient-text">Risk Management</span> System
                </h1>
                <p class="hero-subtitle">Kelola risiko bisnis Anda dengan lebih efisien dan terukur</p>
                <p class="hero-description">
                    RMS adalah platform manajemen risiko terpadu yang membantu Anda mengidentifikasi, 
                    menganalisis, dan mengatasi risiko bisnis dengan solusi yang telah divalidasi oleh para ahli.
                </p>
                <div class="hero-buttons">
                    <?php if (!isset($_SESSION['login'])): ?>
                        <a href="process/login.php" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Mulai Sekarang
                        </a>
                        <a href="process/register.php" class="btn btn-secondary">
                            <i class="bi bi-person-plus"></i> Daftar
                        </a>
                    <?php else: ?>
                        <?php if ($_SESSION['role'] === 'User'): ?>
                            <a href="user/usermain.php" class="btn btn-primary">
                                <i class="bi bi-speedometer2"></i> Dashboard User
                            </a>
                        <?php elseif ($_SESSION['role'] === 'Admin'): ?>
                            <a href="Admin/admindashboard.php" class="btn btn-primary">
                                <i class="bi bi-speedometer2"></i> Dashboard Admin
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-illustration">
                <div class="floating-card card-1">
                    <i class="bi bi-graph-up"></i>
                    <span>Analisis Risiko</span>
                </div>
                <div class="floating-card card-2">
                    <i class="bi bi-shield-check"></i>
                    <span>Mitigasi</span>
                </div>
                <div class="floating-card card-3">
                    <i class="bi bi-chat-dots"></i>
                    <span>Konsultasi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="section-header">
            <h2>Fitur Unggulan</h2>
            <p>Solusi lengkap untuk manajemen risiko bisnis Anda</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h3>Input Risiko</h3>
                <p>Identifikasi dan dokumentasikan setiap risiko yang dihadapi dengan detail lengkap</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h3>Approval System</h3>
                <p>Admin melakukan review dan validasi setiap risiko yang diajukan</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-hammer"></i>
                </div>
                <h3>Mitigasi & Solusi</h3>
                <p>Dapatkan rencana aksi dan solusi terukur untuk setiap risiko</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Laporan Detail</h3>
                <p>Pantau progress dan dapatkan laporan komprehensif tentang semua risiko</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Kolaborasi Tim</h3>
                <p>Bekerja sama antar divisi untuk penyelesaian masalah yang lebih efektif</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <h3>Dashboard Realtime</h3>
                <p>Pantau status risiko secara real-time dengan dashboard yang intuitif</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="section-header">
            <h2>Cara Kerjanya</h2>
            <p>Proses manajemen risiko yang sederhana namun efektif</p>
        </div>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Input Risiko</h3>
                <p>User mengidentifikasi dan memasukkan risiko yang dihadapi</p>
            </div>
            <div class="step-arrow"><i class="bi bi-arrow-right"></i></div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Review Admin</h3>
                <p>Admin melakukan validasi terhadap setiap risiko yang diajukan</p>
            </div>
            <div class="step-arrow"><i class="bi bi-arrow-right"></i></div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Approval</h3>
                <p>Risiko yang valid di-approve untuk tahap selanjutnya</p>
            </div>
            <div class="step-arrow"><i class="bi bi-arrow-right"></i></div>
            <div class="step">
                <div class="step-number">4</div>
                <h3>Solusi & Mitigasi</h3>
                <p>Admin memberikan rencana aksi dan solusi untuk setiap risiko</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Siap Mengelola Risiko Bisnis Anda?</h2>
            <p>Bergabunglah dengan sistem manajemen risiko yang telah terbukti meningkatkan efisiensi operasional</p>
            <?php if (!isset($_SESSION['login'])): ?>
                <a href="process/login.php" class="btn btn-light">Masuk ke Sistem</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2026 Risk Management System. Semua hak dilindungi.</p>
            <p>Sistem yang dirancang untuk membantu organisasi mengelola risiko dengan lebih baik.</p>
        </div>
    </footer>

</body>
</html>