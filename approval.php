<?php
session_start();
require '../resources/functions.php';
$db = new Database();
$admin = "Admin";
$db->checkLogin($admin);

// Get pending data
$pendingData = $db->getPendingData();

// Handle approval
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    if($db->approval($id, $status)) {
        echo "<script>alert('Risiko berhasil " . ($status === 'approved' ? 'di-approve' : 'di-reject') . "'); window.location.href='approval.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status risiko'); window.location.href='approval.php';</script>";
    }
    exit;
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin.css" />
    <title>Approval Risiko - Admin</title>
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
                        <li><a class="text-white text-decoration-none small" href="approval.php" style="color: #ffc107 !important;"><i class="bi bi-check-circle me-1"></i>Approval</a></li>
                        <li><a class="text-white text-decoration-none small" href="admin.php"><i class="bi bi-pencil-square me-1"></i>Manage</a></li>
                        <li><a class="text-white text-decoration-none small" href="Mitigasi.php"><i class="bi bi-lightbulb me-1"></i>Solusi</a></li>
                        <li><a class="text-white text-decoration-none small" href="ahapus.php"><i class="bi bi-trash me-1"></i>Hapus</a></li>
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
    <main class="content flex-grow-1 p-4 bg-light">
        <header class="mb-4">
            <h2 class="fw-bold text-center">Approval Risiko</h2>
            <p class="text-muted text-center">Persetujuan Risiko Baru dari User</p>
        </header>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong>Total Pending:</strong> <span class="badge bg-warning text-dark"><?= count($pendingData) ?></span> risiko menunggu approval
                    </div>
                </div>
            </div>
        </div>

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pendingData)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Tidak ada risiko yang menunggu approval
                                </td>
                            </tr>
                        <?php else:
                            $no = 1;
                            foreach ($pendingData as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['resiko']) ?></strong></td>
                                <td><?= htmlspecialchars($row['divisi']) ?></td>
                                <td>
                                    <span class="badge bg-danger"><?= htmlspecialchars($row['tingkat']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['penyebab']) ?></td>
                                <td><?= htmlspecialchars($row['sumber']) ?></td>
                                <td>
                                    <form method="post" action="approval.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="submit" class="btn btn-success btn-sm me-2" onclick="return confirm('Anda yakin ingin APPROVE risiko ini?')" value="approve" formaction="">
                                            <i class="bi bi-check-lg me-1"></i>Approve
                                        </button>
                                    </form>
                                    <form method="post" action="approval.php" class="d-inline" onsubmit="document.querySelector('input[name=status]').value='rejected';">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" name="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin REJECT risiko ini?')">
                                            <i class="bi bi-x-lg me-1"></i>Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 text-center">
                <a href="admindashboard.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </section>
    </main>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
<script src="admin.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle approve button
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = e.submitter;
                if(button.classList.contains('btn-success')) {
                    // Create hidden status input for approve
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = 'approved';
                    form.appendChild(statusInput);
                }
            });
        });
    });
</script>

</body>
</html>
