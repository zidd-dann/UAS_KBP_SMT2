<?php
session_start();
require '../resources/functions.php';
$db = new user();
$user = "User";
$db->checkLogin($user);

$data_pending = $db->getdatauser();

if (isset($_POST["update"])) {
    $id = $_POST['id'];
    $dataPost = $_POST;
    if ($db->setupdate($dataPost)) {
        echo "<script>alert('Data berhasil diupdate!'); document.location.href = 'update.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!'); document.location.href = 'update.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Risiko - Risk Management</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="user.css" />
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
        <a class="nav-link text-white" href="usermain.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#taskMenu" role="button" aria-expanded="false" aria-controls="taskMenu">       
          <i class="bi bi-list-task me-2"></i>Task
        </a>
        <div class="collapse" id="taskMenu">
          <ul class="list-unstyled ms-4">
            <li><a class="text-white text-decoration-none small" href="tambah.php">Tambah Risiko</a></li>
            <li><a class="text-white text-decoration-none small" href="update.php">Update Risiko</a></li>
            <li><a class="text-white text-decoration-none small" href="hapus.php">Hapus Risiko</a></li>
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
      <h2 class="fw-bold text-center">Update Data Risiko</h2>
      <p class="text-muted text-center">Anda hanya dapat memperbarui risiko dengan status <strong>pending</strong>.</p>
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
              <th>Mitigasi</th>
              <th>Solusi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($data_pending)): ?>
              <tr>
                <td colspan="10" class="text-center">Tidak ada data pending untuk diupdate.</td>
              </tr>
            <?php else:
              $no = 1;
              foreach ($data_pending as $row): ?>
              <tr>
                <form method="post" action="">
                  <td><?= $no++ ?></td>
                  <td><input type="text" name="resiko" value="<?= htmlspecialchars($row['resiko']) ?>" class="form-control form-control-sm" required /></td>
                  <td>
                    <select name="divisi" class="form-select form-select-sm" required>
                      <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'divisi'") as $divisi): ?>
                        <option value="<?= $divisi ?>" <?= $divisi == $row['divisi'] ? 'selected' : '' ?>><?= $divisi ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td>
                    <select name="tingkat" class="form-select form-select-sm" required>
                      <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'tingkat'") as $tingkat): ?>
                        <option value="<?= $tingkat ?>" <?= $tingkat == $row['tingkat'] ? 'selected' : '' ?>><?= $tingkat ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td><textarea name="penyebab" class="form-control form-control-sm" rows="2" required><?= htmlspecialchars($row['penyebab']) ?></textarea></td>
                  <td>
                    <select name="sumber" class="form-select form-select-sm" required>
                      <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'sumber'") as $sumber): ?>
                        <option value="<?= $sumber ?>" <?= $sumber == $row['sumber'] ? 'selected' : '' ?>><?= $sumber ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td><input type="hidden" name="mitigasi" value="<?= htmlspecialchars($row['mitigasi']) ?>" class="form-control form-control-sm" required /></td>
                  <td><input type="hidden" name="solusi" value="<?= htmlspecialchars($row['solusi']) ?>" class="form-control form-control-sm" required /></td>
                  <td><?= htmlspecialchars($row['status']) ?></td>
                  <td class="text-center">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="status" value="<?= $row['status'] ?>">
                    <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                  </td>
                </form>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
<script src="user.js"></script>

</body>
</html>