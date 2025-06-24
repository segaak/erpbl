<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = $_POST['nama'];
    $username_baru = $_POST['username'];
    $email   = $_POST['email'];
    $alamat  = $_POST['alamat'];
    $no_hp   = $_POST['no_hp'];

    // Cek dan simpan foto jika ada
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['size'] > 0) {
        $file = $_FILES['foto_profil'];
        $filename = time() . "_" . basename($file['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("UPDATE users SET nama=?, username=?, email=?, alamat=?, no_hp=?, foto_profil=? WHERE username=?");
            $stmt->bind_param("sssssss", $nama, $username_baru, $email, $alamat, $no_hp, $filename, $username);
        }
    } else {
        $stmt = $conn->prepare("UPDATE users SET nama=?, username=?, email=?, alamat=?, no_hp=? WHERE username=?");
        $stmt->bind_param("ssssss", $nama, $username_baru, $email, $alamat, $no_hp, $username);
    }

    if ($stmt->execute()) {
        $_SESSION['username'] = $username_baru; // update session jika username berubah
        header("Location: profile.php");
        exit;
    } else {
        echo "Gagal mengupdate profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #eaf6ff;
    }
    .edit-box {
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
  <div class="edit-box shadow">
    <div class="d-flex align-items-center mb-4">
      <img src="<?= $user['foto_profil'] ? 'uploads/' . htmlspecialchars($user['foto_profil']) : 'https://i.pravatar.cc/100' ?>" class="profile-img me-3" alt="Profile Photo">
      <div>
        <h5 class="mb-0">Edit Profil</h5>
        <small><?= htmlspecialchars($user['email']) ?></small>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Nick Name</label>
          <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Alamat</label>
          <input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($user['alamat']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">No. Telpon</label>
          <input type="text" class="form-control" name="no_hp" value="<?= htmlspecialchars($user['no_hp']) ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Foto Profil (Opsional)</label>
          <input class="form-control" type="file" name="foto_profil" accept="image/*">
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="profile.php" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
