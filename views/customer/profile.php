<?php 
include 'koneksi.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data user dari database berdasarkan username
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>  <style>
    body {
      
      background-color: #eaf6ff;
    }
    .profile-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
    }
    .profile-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>

<?php include('../../parts/customer/navbar2.php'); ?>

<div class="container mt-5">
  <div class="profile-box">
    <div class="d-flex align-items-center mb-4">
      <img src="<?= $user['foto_profil'] ? 'uploads/' . htmlspecialchars($user['foto_profil']) : 'https://i.pravatar.cc/100' ?>" class="profile-img me-3" alt="Profile Photo">
      <div>
        <h5 class="mb-0"><?= htmlspecialchars($user['username']) ?></h5>
        <small><?= htmlspecialchars($user['email']) ?></small>
      </div>
      <div class="ms-auto">
        <a href="edit_profil.php" class="btn btn-primary">Edit</a>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" disabled>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nick Name</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
      </div>
      <div class="col-md-6 mt-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
      </div>
      <div class="col-md-6 mt-3">
        <label class="form-label">Alamat</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['alamat']) ?>" disabled>
      </div>
      <div class="col-md-6 mt-3">
        <label class="form-label">No. Telpon</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['no_hp']) ?>" disabled>
      </div>
    </div>

    
  </div>
</div>

</body>
</html>
