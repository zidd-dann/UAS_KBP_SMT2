<?php
session_start();
require '../resources/functions.php';
$db = new Database();
$user = "User";
$db->checkLogin($user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Risiko - Risk Management</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="user.css" />

    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff; 
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        label {
            font-weight: 600;
        }
        textarea {
            resize: vertical;
        }
        .bootstrap-select .dropdown-menu li:hover {
        background-color:rgb(36, 35, 35);
        } 


    </style>
</head>
<body>

<div class="wrapper d-flex">

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
            <li><a class="text-white text-decoration-none small active" href="#">Tambah Risiko</a></li>
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
      <h2 class="fw-bold">Tambah Data Risiko</h2>
      <p class="text-muted text-center">Silakan lengkapi semua kolom untuk menambahkan risiko baru.</p>
    </header>

    <section>
      <div class="container rounded shadow-sm bg-white p-4">
        <form action="" method="post">
          
          <div class="mb-3">
            <label for="resiko" class="form-label">Nama Resiko:</label>
            <input type="text" class="form-control" id="resiko" name="resiko" required />
          </div>

          <div class="mb-3">
            <label for="divisi" class="form-label">Divisi:</label>
            <select class="form-select" id="divisi" name="divisi" required>
              <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'divisi'") as $divisi): ?>
                <option value="<?= $divisi ?>"><?= $divisi ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="tingkat" class="form-label">Tingkat:</label>
            <select class="form-select" id="tingkat" name="tingkat" required>
              <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'tingkat'") as $tingkat): ?>
                <option value="<?= $tingkat ?>"><?= $tingkat ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="penyebab" class="form-label">Penyebab:</label>
            <textarea class="form-control" id="penyebab" name="penyebab" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="sumber" class="form-label">Sumber:</label>
            <select class="form-select" id="sumber" name="sumber" required>
              <?php foreach ($db->enum("SHOW COLUMNS FROM resiko LIKE 'sumber'") as $sumber): ?>
                <option value="<?= $sumber ?>"><?= $sumber ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <input type="hidden" name="mitigasi" value="">
          <input type="hidden" name="solusi" value="">
          <input type="hidden" name="status" value="pending">

          <div class="d-grid">
            <button type="submit" name="tambah" class="btn btn-secondary">Submit</button>
          </div>
        </form>
      </div>
    </section>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
<script src="user.js"></script>

<?php
if (isset($_POST["tambah"])) {
    $dataPost = $_POST;
    if ($db->set($dataPost)) {
        echo "<script>alert('Data berhasil ditambahkan!'); document.location.href = 'tambah.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!'); document.location.href = 'tambah.php';</script>";
    }
}
?>

</body>
</html>