<?php
session_start();
require '../resources/functions.php';
$db = new user();
$user = "User";
$db->checkLogin($user);


$data = $db->getdatauser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hapus Risiko - Risk Management</title>

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
      <h2 class="fw-bold text-center">Hapus Data Risiko</h2>
      <p class="text-muted text-center">Data berikut hanya menampilkan risiko dengan status <strong>pending</strong>.</p>
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
            <?php if(empty($data)): ?>
              <tr>
                <td colspan="10" class="text-center">Tidak ada data pending untuk dihapus.</td>
              </tr>
            <?php else:
              $no = 1;
              foreach ($data as $row): ?>
              <tr>
                <form method="post" action="">
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['resiko']) ?></td>
                  <td><?= htmlspecialchars($row['divisi']) ?></td>
                  <td><?= htmlspecialchars($row['tingkat']) ?></td>
                  <td><?= htmlspecialchars($row['penyebab']) ?></td>
                  <td><?= htmlspecialchars($row['sumber']) ?></td>
                  <td><?= htmlspecialchars($row['mitigasi']) ?></td>
                  <td><?= htmlspecialchars($row['solusi']) ?></td>
                  <td><?= htmlspecialchars($row['status']) ?></td>
                  <td>
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <button type="submit" name="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                      Hapus
                    </button>
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

<?php
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    if($db->sethapus($id) > 0) {
        echo "<script>alert('Data berhasil dihapus!'); document.location.href = 'hapus.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); document.location.href = 'hapus.php';</script>";
    }
}
?>

</body>
</html>