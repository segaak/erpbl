<?php
include 'koneksi.php';
include('../../parts/customer/navbar2.php');

if (!isset($_GET['id'])) {
  echo "Produk tidak ditemukan.";
  exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM produk WHERE ID_Produk = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
  echo "Produk tidak ditemukan.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $produk['nama_produk']; ?> - Detail Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f6f7fb;
    }

    .product-detail-container {
      padding: 40px 0;
    }

    .product-image {
      max-width: 100%;
      height: auto;
    }

    .price {
      font-size: 24px;
      color: #3399ff;
      font-weight: bold;
    }

    .price-original {
      text-decoration: line-through;
      color: #888;
      font-size: 14px;
    }

    .discount-badge {
      background-color: red;
      color: white;
      font-size: 12px;
      padding: 2px 5px;
      border-radius: 4px;
    }

    .purchase-box {
      background-color: #e9f4ff;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
    }

    .btn-add {
      background-color: #f0ad4e;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      width: 100%;
      font-size: 16px;
    }

    .quantity-box {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }

    .quantity-box button {
      width: 30px;
      height: 30px;
      font-size: 18px;
      border: none;
      background-color: white;
      border-radius: 5px;
      margin: 0 5px;
    }

    .breadcrumb {
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="container product-detail-container">
  <div class="breadcrumb mb-3">
    <a href="produk.php">Home</a> > <a href="#">Product</a>
  </div>

  <div class="row">
    <!-- Gambar Produk -->
   <div class="col-md-4 text-center">
  <div class="position-relative border rounded p-2" style="border-color: #00aaff; border-width: 2px;">
    <!-- Gambar Utama -->
    <img src="images/produk/<?= $produk['gambar']; ?>" alt="<?= $produk['nama_produk']; ?>" class="img-fluid mb-2" id="mainImage">

    <!-- Badge 1KG -->
    <div class="position-absolute top-50 end-0 translate-middle-y bg-light text-primary fw-bold px-2 py-1" style="writing-mode: vertical-rl; transform: rotate(180deg); border-radius: 0 5px 5px 0;">
      1 KG
    </div>

    <!-- Label Nama Produk -->
    <div class="bg-primary text-white fw-bold py-1 mt-2 rounded-end-pill" style="width: 100px; margin: auto; border-radius: 0 20px 20px 0;">
      <?= $produk['nama_produk']; ?>
    </div>
  </div>

  <!-- Galeri Thumbnail -->
  <div class="d-flex justify-content-center gap-2 mt-3">
    <img src="images/produk/<?= $produk['gambar']; ?>" onclick="changeImage(this.src)" class="border" style="width: 60px; height: 60px; object-fit: contain; cursor: pointer;">
    <img src="images/produk/<?= $produk['gambar']; ?>" onclick="changeImage(this.src)" class="border opacity-50" style="width: 60px; height: 60px; object-fit: contain; cursor: pointer;">
    <img src="images/produk/<?= $produk['gambar']; ?>" onclick="changeImage(this.src)" class="border opacity-50" style="width: 60px; height: 60px; object-fit: contain; cursor: pointer;">
  </div>

  <p class="mt-2 mb-0 fw-semibold">Stock = <?= $produk['stok']; ?></p>
</div>


    <!-- Deskripsi -->
    <div class="col-md-5">
      <h3><?= $produk['nama_produk']; ?></h3>
      <p class="text-muted">Category: <?= $produk['kategori']; ?></p>

      <div class="mb-2">
        <span class="discount-badge">10%</span>
        <span class="price ms-2">Rp<?= number_format($produk['harga'- ]); ?></span>
        <div class="price-original">Rp<?= number_format($produk['harga'] * 1.1); ?></div>
      </div>
<br>
      <h6>Deskripsi</h6>
   <h10><?= $produk['deskripsi']; ?></h10>
    </div>

    <!-- Pembelian -->
    <div class="col-md-3">
      <div class="purchase-box">
        <form action="add_to_cart.php" method="post">
          <input type="hidden" name="id_produk" value="<?= $produk['ID_Produk']; ?>">
          <label for="quantity" class="form-label fw-bold mb-2">Jumlah pembelian</label>
          <div class="quantity-box">
            <button type="button" onclick="changeQty(-1)">-</button>
            <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control text-center" style="width: 60px;">
            <button type="button" onclick="changeQty(1)">+</button>
          </div>
          <button type="submit" class="btn-add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function changeQty(amount) {
    const input = document.getElementById('quantity');
    let current = parseInt(input.value);
    if (!isNaN(current)) {
      current = current + amount;
      if (current < 1) current = 1;
      input.value = current;
    }
  }
    function changeImage(src) {
    document.getElementById('mainImage').src = src;
  }
</script>

</body>
</html>
