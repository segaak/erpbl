<?php
include 'koneksi.php';


// Anggap user sudah login dan punya session user_i
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
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
    .email-box {
      background-color: #f1f5ff;
      padding: 15px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
    <?php include('../../parts/customer/navbar2.php'); ?>
<div class="container mt-5">
  <div class="profile-box">
    <div class="d-flex align-items-center mb-4">
      <img src="https://i.pravatar.cc/100" class="profile-img me-3" alt="Profile Photo">
      <div>
        <h5 class="mb-0"><?= $user['fullname'] ?></h5>
        <small><?= $user['email'] ?></small>
      </div>
      <div class="ms-auto">
        <a href="edit_profil.php" class="btn btn-primary">Edit</a>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" value="<?= $user['fullname'] ?>" disabled>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nick Name</label>
        <input type="text" class="form-control" value="<?= $user['nickname'] ?>" disabled>
      </div>
      <div class="col-md-6 mt-3">
        <label class="form-label">No. Telpon</label>
        <input type="text" class="form-control" value="<?= $user['phone'] ?>" disabled>
      </div>
      <div class="col-md-6 mt-3">
        <label class="form-label">Alamat</label>
        <input type="text" class="form-control" value="<?= $user['address'] ?>" disabled>
      </div>
    </div>

    <h6>My Email Address</h6>
    <div class="email-box d-flex align-items-center mb-2">
      <i class="bi bi-envelope-fill me-2"></i>
      <div>
        <?= $user['email'] ?><br>
        <small class="text-muted">1 month ago</small>
      </div>
    </div>
    <button class="btn btn-outline-primary">+ Add Email Address</button>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>