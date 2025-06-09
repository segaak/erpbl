<?php
session_start();
include 'koneksi.php';

// === 1. Tambah ke keranjang ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
    $id_produk = (int)$_POST['id_produk'];
    $quantity = (int)($_POST['quantity'] ?? 1);

    $_SESSION['cart'][$id_produk] = ($_SESSION['cart'][$id_produk] ?? 0) + $quantity;
    header("Location: keranjang.php");
    exit;
}

// === 2. Ambil data produk ===
function getProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE ID_Produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// === 3. Diskon ===
$discountCode = 'Suppli2024';
$discountAmount = 22000;
$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;
$appliedDiscount = 0;
$couponInput = $_POST['coupon'] ?? '';
if (strcasecmp($couponInput, $discountCode) === 0) {
    $appliedDiscount = $discountAmount;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - SI-SUPLY</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f6f7fb; }
    .section-box {
      background-color: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .cart-table img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 10px;
    }
    .btn-checkout {
      background-color: #4db6ff;
      color: #fff;
      font-weight: bold;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
    }
    .summary-table td {
      padding: 6px 0;
    }
    .summary-table td:last-child {
      text-align: right;
    }
    .text-sm { font-size: 14px; }
  </style>
</head>
<body>

<?php include('../../parts/customer/navbar2.php'); ?>

<div class="container mt-4 mb-5">
  <div class="breadcrumb mb-3">
    <a href="produk.php">Home</a> > Checkout
  </div>
  <h5 class="mb-3">Checkout</h5>

  <div class="row">
    <!-- Kiri -->
    <div class="col-md-7">
      <div class="section-box mb-3">
        <strong>ALAMAT PENGIRIMAN</strong><br>
        <div class="d-flex justify-content-between">
          <div>
            Rumah<br>
            Jl. Babarsari Jl. Tambak Bayan No.3, Janti, Caturtunggal, Kec. Depok, Sleman, DI Yogyakarta 55281
          </div>
          <button class="btn btn-outline-secondary btn-sm">Ganti</button>
        </div>
      </div>

      <div class="section-box mb-3">
        <table class="table cart-table align-middle">
          <thead>
            <tr>
              <th>Description</th>
              <th>Unit</th>
              <th>Price (Rp)</th>
              <th>Quantity</th>
              <th>Total (Rp)</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart as $id => $qty):
              $product = getProduct($conn, $id);
              if (!$product) continue;
              $itemTotal = $product['harga'] * $qty;
              $subtotal += $itemTotal;
            ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="img/<?= htmlspecialchars($product['gambar']); ?>" alt="">
                  <?= htmlspecialchars($product['nama_produk']); ?>
                </div>
              </td>
              <td><?= htmlspecialchars($product['satuan']); ?></td>
              <td>Rp <?= number_format($product['harga']); ?></td>
              <td><?= $qty; ?></td>
              <td>Rp <?= number_format($itemTotal); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Diskon -->
        <form method="POST" class="d-flex mt-3">
          <input type="text" name="coupon" class="form-control me-2" placeholder="Suppli2024">
          <button type="submit" class="btn btn-primary">Apply Discount</button>
          <?php if ($appliedDiscount): ?>
            <div class="ms-3 fw-bold text-success">Discount Rp <?= number_format($appliedDiscount); ?></div>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <!-- Kanan -->
    <div class="col-md-5">
      <div class="section-box">
        <h6>Metode Pembayaran <a href="#" class="float-end text-sm">Lihat Semua</a></h6>
       <div class="mb-3 d-flex justify-content-between align-items-start">
    <div class="d-flex align-items-center">
      <img src="img/bca-va.png" height="24" class="me-2">
      <div>
        <strong>BCA Virtual Account</strong><br>
        <small class="text-muted">Mudah & terverifikasi otomatis</small>
      </div>
    </div>
    <input class="form-check-input mt-2" type="radio" name="metode_pembayaran" value="BCA Virtual Account" checked>
  </div>

  <div class="mb-3 d-flex justify-content-between align-items-start">
    <div class="d-flex align-items-center">
      <img src="img/alfamart.png" height="24" class="me-2">
      <div>
        <strong>Alfamart / Lawson / Dan+Dan</strong><br>
        <small class="text-muted">Bayar di kasir di seluruh minimarket</small>
      </div>
    </div>
    <input class="form-check-input mt-2" type="radio" name="metode_pembayaran" value="Alfamart">
  </div>

        <hr>

        <h6>Cek Ringkasan Transaksimu</h6>
        <?php
          $ongkir = 50000;
          $asuransi = 5000;
          $totalTagihan = $subtotal + $ongkir + $asuransi - $appliedDiscount;
        ?>
        <table class="summary-table w-100">
          <tr>
            <td>Total Harga (<?= count($cart); ?> barang)</td>
            <td>Rp <?= number_format($subtotal); ?></td>
          </tr>
          <tr>
            <td>Total Ongkos Kirim</td>
            <td>Rp <?= number_format($ongkir); ?></td>
          </tr>
          <tr>
            <td>Total Asuransi Pengiriman</td>
            <td>Rp <?= number_format($asuransi); ?></td>
          </tr>
          <tr>
            <td>Diskon</td>
            <td>Rp <?= number_format($appliedDiscount); ?></td>
          </tr>
          <tr class="fw-bold">
            <td>Total Tagihan</td>
            <td>Rp <?= number_format($totalTagihan); ?></td>
          </tr>
        </table>

        <a href="pembayaran_berhasil.php" class="btn btn-checkout mt-3">Bayar Sekarang</a>
        <p class="small text-muted mt-2 text-center">
          Dengan melanjutkan pembayaran, kamu menyetujui S&K<br> Asuransi Pengiriman & Proteksi.
        </p>
      </div>
    </div>
  </div>
</div>

<footer class="text-center text-white bg-primary py-2 mt-4">
  © SI-SUPLY 2024
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
