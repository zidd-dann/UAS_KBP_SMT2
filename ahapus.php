<?php
session_start();
require '../resources/functions.php';
$db = new Database();
$admin = "Admin";
$db->checkLogin($admin);

$data = $db->getdata();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin.css" />
    <title>Hapus Masalah</title>
</head>
<body>

<?php
// Show toast if there's a message
if (isset($_SESSION['toast_message'])) {
    $toastType = $_SESSION['toast_message'];
    $toastText = $_SESSION['toast_text'];
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('$toastType', '$toastText');
        });
    </script>";
    unset($_SESSION['toast_message']);
    unset($_SESSION['toast_text']);
}
?>

<div class="wrapper">

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
                        <li><a class="text-white text-decoration-none small" href="approval.php"><i class="bi bi-check-circle me-1"></i>Approval</a></li>
                        <li><a class="text-white text-decoration-none small" href="admin.php"><i class="bi bi-pencil-square me-1"></i>Manage</a></li>
                        <li><a class="text-white text-decoration-none small" href="Mitigasi.php"><i class="bi bi-lightbulb me-1"></i>Solusi</a></li>
                        <li><a class="text-white text-decoration-none small active" href="hapus.php"><i class="bi bi-trash me-1"></i>Hapus</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <hr class="text-white mt-auto"/>
        <div>
            <a class="nav-link text-white" href="../index.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="content flex-grow-1 bg-light">

        <header class="mb-4">
            <h2 class="fw-bold text-center">Hapus Risiko</h2>
            <p class="text-muted text-center">Hapus risiko yang sudah diproses (Approved/Rejected)</p>
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

            <div class="table-responsive rounded shadow-sm bg-white p-3">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th style="min-width: 200px;">Risiko</th>
                            <th style="min-width: 120px;">Divisi</th>
                            <th style="min-width: 100px;">Tingkat</th>
                            <th style="min-width: 150px;">Penyebab</th>
                            <th style="min-width: 120px;">Sumber</th>
                            <th style="min-width: 150px;">Mitigasi</th>
                            <th style="min-width: 150px;">Solusi</th>
                            <th style="min-width: 100px;">Status</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Filter data berdasarkan parameter GET
                        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                        if ($filter === 'approved') {
                            $data_filtered = array_filter($data, function($row) {
                                return $row['status'] === 'approved';
                            });
                            $empty_message = 'Tidak ada risiko yang sudah di-approve untuk dihapus.';
                        } elseif ($filter === 'rejected') {
                            $data_filtered = array_filter($data, function($row) {
                                return $row['status'] === 'rejected';
                            });
                            $empty_message = 'Tidak ada risiko yang sudah di-reject untuk dihapus.';
                        } else {
                            $data_filtered = array_filter($data, function($row) {
                                return $row['status'] === 'approved' || $row['status'] === 'rejected';
                            });
                            $empty_message = 'Tidak ada risiko yang sudah diproses untuk dihapus.';
                        }

                        if(empty($data_filtered)) {
                            echo '<tr><td colspan="10" class="text-center text-warning"><i class="bi bi-info-circle me-2"></i>' . $empty_message . '</td></tr>';
                        } else {
                            $no = 1;
                            foreach ($data_filtered as $row): ?>
                                <form method="post" action="">
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($row["resiko"]) ?></strong></td>
                                        <td><?= htmlspecialchars($row["divisi"]) ?></td>
                                        <td>
                                            <span class="badge bg-danger"><?= htmlspecialchars($row["tingkat"]) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row["penyebab"]) ?></td>
                                        <td><?= htmlspecialchars($row["sumber"]) ?></td>
                                        <td>
                                            <?php if(empty($row["mitigasi"])): ?>
                                                <span class="text-muted">-</span>
                                            <?php else: ?>
                                                <?= htmlspecialchars($row["mitigasi"]) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(empty($row["solusi"])): ?>
                                                <span class="text-muted">-</span>
                                            <?php else: ?>
                                                <?= htmlspecialchars($row["solusi"]) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row["status"] === 'approved'): ?>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Approved
                                                </span>
                                            <?php elseif($row["status"] === 'rejected'): ?>
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="submit" class="btn btn-danger btn-sm delete-btn"
                                                    onclick="return confirmDelete(this);">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                            <?php endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Info Section -->
            <div class="mt-4">
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong>Informasi:</strong> Halaman ini menampilkan risiko yang sudah diproses (Approved/Rejected).
                        Risiko dengan status 'Pending' tidak dapat dihapus dari sini untuk menjaga integritas proses approval.
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i>Data berhasil dihapus!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle me-2"></i>Gagal menghapus data!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="admin.js"></script>
<script>
function showToast(type, message) {
    const toastId = type === 'success' ? 'successToast' : 'errorToast';
    const toastElement = document.getElementById(toastId);

    // Update message if different
    const toastBody = toastElement.querySelector('.toast-body');
    if (message) {
        toastBody.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${message}`;
    }

    const toast = new bootstrap.Toast(toastElement);
    toast.show();
}

// Clear search when filter changes
document.querySelectorAll('a[href*="?filter="]').forEach(link => {
    link.addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
    });
});
</script>

</body>
</html>
<?php
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    if($db->sethapus($id) > 0) {
        $_SESSION['toast_message'] = 'success';
        $_SESSION['toast_text'] = 'Data berhasil dihapus!';
        header('Location: hapus.php');
        exit();
    } else {
        $_SESSION['toast_message'] = 'error';
        $_SESSION['toast_text'] = 'Gagal menghapus data!';
        header('Location: hapus.php');
        exit();
    }
}
?>