<?php
session_start();
require '../resources/functions.php';
$db = new Database();
$admin = "Admin";
$db->checkLogin($admin);

$data = $db->getdata();
$pendingCount = count($db->getPendingData());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin.css" />
    <title>ADMIN - Dashboard</title>
</head>
<body>

<div class="wrapper d-flex">

    <!-- Sidebar -->
    <nav id="sidebar" class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0">RMS</h4>
            <button id="toggle-btn" class="btn btn-sm btn-light d-md-none"><i class="bi bi-list"></i></button>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="admindashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#taskMenu" role="button" 
                   aria-expanded="false" aria-controls="taskMenu">
                    <i class="bi bi-list-task me-2"></i>Task
                </a>
                <div class="collapse" id="taskMenu">
                    <ul class="list-unstyled ms-4">
                        <li><a class="text-white text-decoration-none small" href="approval.php"><i class="bi bi-check-circle me-1"></i>Approval <?php if($pendingCount > 0): ?><span class="badge bg-danger ms-2"><?= $pendingCount ?></span><?php endif; ?></a></li>
                        <li><a class="text-white text-decoration-none small" href="admin.php"><i class="bi bi-pencil-square me-1"></i>Manage</a></li>
                        <li><a class="text-white text-decoration-none small" href="Mitigasi.php"><i class="bi bi-lightbulb me-1"></i>Solusi</a></li>
                        <li><a class="text-white text-decoration-none small" href="ahapus.php"><i class="bi bi-trash me-1"></i>Hapus</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <hr class="text-white mt-auto" />
        <div>
            <a class="nav-link text-white" href="../index.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="content flex-grow-1 p-4 bg-light">
        <header class="mb-4">
            <h2 class="fw-bold text-center">Risk Management System</h2>
            <p class="text-muted text-center">Administrator Workspace</p>
        </header>

        <!-- Statistics -->
        <div class="row mb-9">
            <?php
            $approved_count = count(array_filter($data, function($row) { return $row['status'] === 'approved'; }));
            $rejected_count = count(array_filter($data, function($row) { return $row['status'] === 'rejected'; }));
            $total_processed = $approved_count + $rejected_count;
            ?>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill fs-1 mb-2"></i>
                        <h5 class="card-title">Approved</h5>
                        <h3 class="mb-0"><?= $approved_count ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle-fill fs-1 mb-2"></i>
                        <h5 class="card-title">Rejected</h5>
                        <h3 class="mb-0"><?= $rejected_count ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-grid-fill fs-1 mb-2"></i>
                        <h5 class="card-title">Total Data</h5>
                        <h3 class="mb-0"><?= $total_processed ?></h3>
                    </div>
                </div>
            </div>
        </div>
<br>
        <section>
            <!-- Search and Filter -->
            <div class="row mb-7">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari risiko..." onkeyup="filterTable()">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()" title="Clear Search">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>Terakhir update: <?= date('d/m/Y H:i') ?>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="btn-group d-flex flex-wrap" role="group" aria-label="Filter risiko">
                        <a href="?filter=all" class="btn btn-outline-primary flex-fill <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : '' ?>">
                            <i class="bi bi-grid me-1"></i>Semua (<?= $total_processed ?>)
                        </a>
                        <a href="?filter=approved" class="btn btn-outline-success flex-fill <?= (isset($_GET['filter']) && $_GET['filter'] === 'approved') ? 'active' : '' ?>">
                            <i class="bi bi-check-circle me-1"></i>Approved (<?= $approved_count ?>)
                        </a>
                        <a href="?filter=rejected" class="btn btn-outline-danger flex-fill <?= (isset($_GET['filter']) && $_GET['filter'] === 'rejected') ? 'active' : '' ?>">
                            <i class="bi bi-x-circle me-1"></i>Rejected (<?= $rejected_count ?>)
                        </a>
                    </div>
                </div>
            </div>

        <?php if($pendingCount > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Ada <?= $pendingCount ?> Risiko Menunggu Approval!</strong> Silakan klik <a href="approval.php" class="alert-link">di sini</a> untuk me-review dan approve/reject risiko baru.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <section>
            <div class="table-responsive rounded shadow-sm bg-white p-3">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Masalah</th>
                            <th>Divisi</th>
                            <th>Tingkat</th>
                            <th>Penyebab</th>
                            <th>Sumber</th>
                            <th>Mitigasi</th>
                            <th>Solusi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Data masih kosong.</td>
                            </tr>
                        <?php else: 
                            $no = 1;
                            foreach ($data as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['resiko']) ?></td>
                                    <td><?= htmlspecialchars($row['divisi']) ?></td>
                                    <td><?= htmlspecialchars($row['tingkat']) ?></td>
                                    <td><?= htmlspecialchars($row['penyebab']) ?></td>
                                    <td><?= htmlspecialchars($row['sumber']) ?></td>
                                    <td><?= htmlspecialchars($row['mitigasi']) ?></td>
                                    <td><?= htmlspecialchars($row['solusi']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                </tr>
                            <?php endforeach; 
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
<script src="admin.js"></script>
</body>
</html>
