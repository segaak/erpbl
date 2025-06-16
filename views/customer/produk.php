<?php
include 'koneksi.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
  $id_produk = (int)$_POST['id_produk'];
  $_SESSION['cart'][$id_produk] = ($_SESSION['cart'][$id_produk] ?? 0) + 1;
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SI-SUPLY - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f6f7fb; }
    .hero {
      background-image: url('images/herobg.png');
      background-size: cover;
      background-position: center top;
      color: #fff; padding: 80px 0; text-align: left;
    }
    .search-bar { max-width: 500px; margin: 20px 0; background: white; padding: 8px 15px; border-radius: 10px; }
    .category-card {
      border-radius: 15px; background-color: #fff2d8; padding: 15px; text-align: center; transition: all 0.3s;
      cursor: pointer;
    }
    .category-card:hover { transform: translateY(-5px); }
    .active-kategori {
      border: 2px solid #007bff;
      background-color: #e6f0ff;
    }
    .product-card {
      background-color: white; border-radius: 15px; padding: 15px; text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05); height: 100%; transition: 0.3s;
    }
    .product-card img {
      height: 100px; object-fit: contain; margin-bottom: 10px; transition: transform 0.2s ease;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05); }
    .product-card:hover img { transform: scale(1.05); }
    .btn-add { background-color: #f0ad4e; color: white; border: none; border-radius: 15px; padding: 5px 15px; }
    footer { background-color: #73c2f9; color: white; padding: 10px 0; text-align: center; }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<?php include('../../parts/customer/navbar2.php'); ?>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h2>Fresh Savings Every Week! Enjoy Up to 10% Off on Select Produce</h2>
    <p>Fresh fruits and vegetables, dairy products, snacks, beverages, household essentials.</p>
    <div class="search-bar">
      <input type="text" class="form-control" placeholder="Search for items...">
    </div>
    <a href="#" class="btn btn-light text-primary mt-2">Shop Now</a>
  </div>
</section>

<!-- Categories (Dynamic) -->
<section class="container my-5">
  <h5 class="mb-3">Explore Categories</h5>
  <div class="row g-3">
   <?php
$kategori_query = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk");
while ($kat = mysqli_fetch_assoc($kategori_query)) :
  $nama_kategori = $kat['kategori'];
?>
        <div class="col-4 col-md-2">
    <div class="category-card kategori-filter" data-kategori="<?= $nama_kategori; ?>">
      <div class="mt-2"><?= $nama_kategori; ?></div>
    </div>
  </div>
<?php endwhile; ?>
  </div>
</section>

<!-- Featured Products -->
<section class="container mb-5">
  <h5 class="mb-4">Featured Products</h5>

  <!-- Filter Tabs -->
  <div class="d-flex gap-2 mb-4">
    <button class="btn btn-outline-dark btn-sm filter-btn active" data-filter="all">Popular buys</button>
    <button class="btn btn-outline-dark btn-sm filter-btn" data-filter="discount">Discounted</button>
  </div>

  <div class="row g-3">
    <?php
    $produk_query = mysqli_query($conn, "SELECT * FROM produk");
    while ($row = mysqli_fetch_assoc($produk_query)) :
      $harga = $row['harga'];
      $harga_diskon = $row['harga_diskon'];
      $is_diskon = (!empty($harga_diskon) && $harga_diskon < $harga);
    ?>
    <div class="col-6 col-md-4 col-lg-2 produk-item <?= $is_diskon ? 'discounted' : ''; ?>" data-kategori="<?= $row['kategori']; ?>">
      <a href="produk-detail.php?id=<?= $row['ID_Produk']; ?>" style="text-decoration: none; color: inherit;">
        <div class="card h-100 shadow-sm border-0">
          <img src="images/produk/<?= $row['gambar']; ?>" class="card-img-top p-3" alt="<?= $row['nama_produk']; ?>" style="height: 140px; object-fit: contain;">
          <div class="card-body p-2 d-flex flex-column" style="min-height: 150px;">
            <p class="text-uppercase text-muted small mb-1"><?= $row['kategori']; ?></p>
            <h6 class="card-title mb-2" style="font-size: 0.95rem;"><?= $row['nama_produk']; ?></h6>
            <?php if ($is_diskon): ?>
              <div class="d-flex align-items-center justify-content-between mt-1">
                <div>
                  <div class="text-danger text-decoration-line-through small">Rp<?= number_format($harga, 0, ',', '.'); ?></div>
                  <div class="fw-bold m-0" style="font-size: 1rem;">Rp<?= number_format($harga_diskon, 0, ',', '.'); ?></div>
                </div>
                <button type="button" class="btn btn-outline-warning btn-sm d-flex align-items-center" style="border-radius: 10px;">
                  <i class="bi bi-cart me-3"></i> Add
                </button>
              </div>
            <?php else: ?>
              <div class="d-flex align-items-center justify-content-between mt-1">
                <div class="fw-bold m-0" style="font-size: 1rem;">Rp<?= number_format($harga, 0, ',', '.'); ?></div>
                <button type="button" class="btn btn-outline-warning btn-sm d-flex align-items-center" style="border-radius: 10px;">
                  <i class="bi bi-cart me-3"></i> Add
                </button>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</section>

<footer>
  Copyright ©SI-Suply 2024
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Filter Button (Popular, Discounted)
  const buttons = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('.produk-item');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.getAttribute('data-filter');
      items.forEach(item => {
        const isDiscounted = item.classList.contains('discounted');
        if (filter === 'all') {
          item.style.display = 'block';
        } else if (filter === 'discount') {
          item.style.display = isDiscounted ? 'block' : 'none';
        }
      });

      // Reset kategori
      document.querySelectorAll('.kategori-filter').forEach(k => k.classList.remove('active-kategori'));
    });
  });

  // Filter by Kategori
  document.querySelectorAll('.kategori-filter').forEach(card => {
    card.addEventListener('click', function () {
      const kategori = this.getAttribute('data-kategori');
      items.forEach(item => {
        const itemKategori = item.getAttribute('data-kategori');
        item.style.display = (itemKategori === kategori) ? 'block' : 'none';
      });

      document.querySelectorAll('.kategori-filter').forEach(c => c.classList.remove('active-kategori'));
      this.classList.add('active-kategori');

      // Reset filter button
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    });
  });
</script>

</body>
</html>
