<?php
include 'koneksi.php';

$keyword = $_GET['q'] ?? '';
$kategori = $_GET['category'] ?? '';

// Query untuk mencari berdasarkan nama produk dan kategori
$sql = "SELECT * FROM produk WHERE 1=1";
if (!empty($keyword)) {
  $sql .= " AND nama_produk LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%'";
}
if (!empty($kategori)) {
  $sql .= " AND kategori LIKE '%" . mysqli_real_escape_string($conn, $kategori) . "%'";
}

$result = mysqli_query($conn, $sql);

// Jika hanya 1 produk ditemukan → langsung redirect ke detail
if (mysqli_num_rows($result) === 1) {
  $produk = mysqli_fetch_assoc($result);
  header("Location: produk-detail.php?id=" . $produk['ID_Produk']);
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h3>Hasil Pencarian Produk</h3>
    <hr>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="images/produk/<?= $row['gambar']; ?>" class="card-img-top" alt="<?= $row['nama_produk']; ?>" style="height: 180px; object-fit: contain;">
              <div class="card-body">
                <h5 class="card-title"><?= $row['nama_produk']; ?></h5>
                <p class="card-text text-muted">Kategori: <?= $row['kategori']; ?></p>
                <p class="fw-bold text-primary">Rp<?= number_format($row['harga']); ?></p>
                <a href="produk-detail.php?id=<?= $row['ID_Produk']; ?>" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-danger">Produk tidak ditemukan. Silakan coba kata kunci lain.</p>
    <?php endif; ?>
  </div>
</body>
</html>
