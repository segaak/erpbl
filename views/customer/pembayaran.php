<?php
session_start();
include 'koneksi.php';

// Tambah ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
    $id_produk = (int)$_POST['id_produk'];
    $quantity = (int)($_POST['quantity'] ?? 1);
    $_SESSION['cart'][$id_produk] = ($_SESSION['cart'][$id_produk] ?? 0) + $quantity;
    header("Location: keranjang.php");
    exit;
}

// Ambil data produk
function getProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE ID_Produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Inisialisasi variabel
$discountCode = 'Suppli2024';
$discountAmount = 22000;
$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;
$appliedDiscount = 0;
$couponInput = $_POST['coupon'] ?? '';
if (strcasecmp($couponInput, $discountCode) === 0) {
    $appliedDiscount = $discountAmount;
}
$totalQty = array_sum($cart);
$ongkir = 50000;
$asuransi = 5000;
$totalTagihan = 0;
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
      
       
       <!-- FORM PEMBAYARAN -->
<form id="formBayar" method="POST">
  <div class="section-box">
    <h6>Metode Pembayaran 
      <a href="#" class="float-end text-sm" onclick="event.preventDefault(); document.getElementById('more-methods').classList.toggle('d-none');">Lihat Semua</a>
    </h6>

    <!-- Metode default -->
    <div class="mb-3 d-flex justify-content-between align-items-start">
      <div class="d-flex align-items-center">
        <img src="images/logobca.png" height="24" class="me-2">
        <div>
          <strong>BCA Virtual Account</strong><br>
          <small class="text-muted">Mudah & terverifikasi otomatis</small>
        </div>
      </div>
      <input id="metodeInput" class="form-check-input mt-2" type="radio" name="metode_pembayaran" value="BCA Virtual Account" checked>
    </div>

    <!-- Metode tambahan -->
    <div id="more-methods" class="d-none">
      <div class="mb-3 d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
          <img src="images/logogopay.png" height="24" class="me-2">
          <div>
            <strong>GoPay</strong><br>
            <small class="text-muted">Pembayaran cepat lewat QR</small>
          </div>
        </div>
        <input class="form-check-input mt-2" type="radio" name="metode_pembayaran" value="GoPay">
      </div>
      <div class="mb-3 d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
          <img src="images/logospay.png" height="24" class="me-2">
          <div>
            <strong>ShopeePay</strong><br>
            <small class="text-muted">Dompet digital Shopee</small>
          </div>
        </div>
        <input class="form-check-input mt-2" type="radio" name="metode_pembayaran" value="ShopeePay">
      </div>
    </div>

  


          <hr>

          <!-- Ringkasan Biaya -->
          <?php $totalTagihan = $subtotal + $ongkir + $asuransi - $appliedDiscount; ?>
          <h6>Cek Ringkasan Transaksimu</h6>
          <table class="summary-table w-100">
            <tr>
              <td>Total Harga (<?= $totalQty; ?> barang)</td>
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

          <!-- Hidden input untuk total & submit -->
          <input type="hidden" name="total_bayar" value="<?= $totalTagihan; ?>">
          <button type="submit" class="btn btn-checkout mt-3">Bayar Sekarang</button>

          <p class="small text-muted mt-2 text-center">
            Dengan melanjutkan pembayaran, kamu menyetujui S&K<br> Asuransi Pengiriman & Proteksi.
          </p>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById("formBayar").addEventListener("submit", function(e) {
  const metode = document.querySelector('input[name="metode_pembayaran"]:checked').value.toLowerCase();
  if (metode.includes("bca")) {
    this.action = "kode_pembayaran.php";
  } else if (metode.includes("gopay") || metode.includes("shopee")) {
    this.action = "qr_payment.php";
  } else {
    // fallback default
    this.action = "qr_payment.php";
  }
});
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
