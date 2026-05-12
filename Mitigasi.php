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
    <title>Kotak Solusi</title>
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
                        <li><a class="text-white text-decoration-none small" href="approval.php"><i class="bi bi-check-circle me-1"></i>Approval</a></li>
                        <li><a class="text-white text-decoration-none small" href="admin.php"><i class="bi bi-pencil-square me-1"></i>Manage</a></li>
                        <li><a class="text-white text-decoration-none small active" href="Mitigasi.php"><i class="bi bi-lightbulb me-1"></i>Solusi</a></li>
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
            <h2 class="fw-bold text-center">Risk Management System</h2>
            <p class="text-muted text-center">Administrator Workspace - Mitigasi & Solusi</p>
        </header>

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
                            <th>Status</th>
                            <th>Mitigasi</th>
                            <th>Solusi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data)): ?>
                            <tr>
                                <td colspan="10" class="text-center">Data masih kosong.</td>
                            </tr>
                        <?php else:
                            // Filter yang statusnya approved atau pending
                            $data_processed = array_filter($data, function($row) {
                                return $row['status'] === 'approved' || $row['status'] === 'pending';
                            });

                            if(empty($data_processed)) {
                                echo '<tr><td colspan="10" class="text-center">Belum ada masalah untuk ditambahkan mitigasi dan solusi.</td></tr>';
                            } else {
                                $no = 1;
                                foreach ($data_processed as $row): ?>
                                    <form method="post" action="">
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row["resiko"]) ?></td>
                                            <td><?= htmlspecialchars($row["divisi"]) ?></td>
                                            <td><?= htmlspecialchars($row["tingkat"]) ?></td>
                                            <td><?= htmlspecialchars($row["penyebab"]) ?></td>
                                            <td><?= htmlspecialchars($row["sumber"]) ?></td>
                                            <td>
                                                <?php if ($row['status'] === 'pending'): ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($row["mitigasi"])): ?>
                                                    <?= htmlspecialchars($row["mitigasi"]) ?>
                                                <?php else: ?>
                                                    <input type="text" name="mitigasi" class="form-control form-control-sm" placeholder="Masukkan Mitigasi"
                                                           value="<?= htmlspecialchars($_POST['mitigasi'] ?? '') ?>">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($row["solusi"])): ?>
                                                    <?= htmlspecialchars($row["solusi"]) ?>
                                                <?php else: ?>
                                                    <input type="text" name="solusi" class="form-control form-control-sm" placeholder="Masukkan Solusi"
                                                           value="<?= htmlspecialchars($_POST['solusi'] ?? '') ?>">
                                                <?php endif; ?>
                                            </td>
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <td>
                                                <?php if (empty($row['mitigasi']) || empty($row['solusi'])): ?>
                                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                                                <?php else: ?>
                                                    <span class="text-success">Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </form>
                                <?php endforeach;
                            }
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
<?php
if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $mitigasi = $_POST["mitigasi"];
    $solusi = $_POST["solusi"];

    // Simpan ke database jika kedua nilai diisi
    if (!empty($mitigasi) && !empty($solusi)) {
        if ($db->setMitigasiSolusi($id, $mitigasi, $solusi)) {
            echo "<script>alert('Mitigasi dan Solusi berhasil ditambahkan!'); window.location.href='Mitigasi.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan mitigasi dan solusi!');</script>";
        }
    } else {
        echo "<script>alert('Mohon isi kedua kolom Mitigasi dan Solusi sebelum menyimpan.');</script>";
    }
}
?>