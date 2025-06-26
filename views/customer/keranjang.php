<?php
session_start();
include 'koneksi.php'; // koneksi ke database

// === 1. PROSES ADD TO CART ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
    $id_produk = (int)$_POST['id_produk'];
    $quantity = (int)($_POST['quantity'] ?? 1);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id_produk])) {
        $_SESSION['cart'][$id_produk] += $quantity;
    } else {
        $_SESSION['cart'][$id_produk] = $quantity;
    }

    // Redirect agar tidak memproses ulang saat refresh
    header("Location: keranjang.php");
    exit;
}

// === 2. FUNGSI AMBIL DATA PRODUK ===
function getProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE ID_Produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// === 3. VARIABEL DISKON ===
$discountCode = 'Suppli2024';
$discountAmount = 22000;
$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;
$appliedDiscount = 0;
$couponInput = $_POST['coupon'] ?? '';

// === 4. CEK KUPON ===
if ($couponInput === $discountCode) {
    $appliedDiscount = $discountAmount;
}
$totalQty = 0; // dipindah ke sini agar hitung yang valid
$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f6f7fb;
    }

    .cart-table img {
      width: 60px;
      height: auto;
    }

    .qty-box {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .qty-box button {
      border: none;
      background: #ddd;
      width: 30px;
      height: 30px;
      font-size: 18px;
      border-radius: 5px;
    }

    .qty-box input {
      width: 40px;
      text-align: center;
      border: 1px solid #ccc;
      margin: 0 5px;
      border-radius: 5px;
    }

    .remove-item {
      color: red;
      cursor: pointer;
      font-weight: bold;
    }

    .summary-box {
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 8px rgba(0,0,0,0.05);
    }

    .btn-checkout {
      background-color: #ff5f2e;
      color: white;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 10px;
      width: 100%;
    }

    .breadcrumb {
      font-size: 14px;
    }

    .coupon-box input {
      width: 200px;
    }
  </style>
</head>
<body>
  <?php include('../../parts/customer/navbar2.php'); ?>
<div class="container my-5">
  <div class="breadcrumb mb-4">
    <a href="produk.php">Home</a> > <a href="#">Cart</a>
  </div>
<?php if (count($cart) === 0): ?>
  <div class="alert alert-info">Keranjang Anda kosong.</div>
  <a href="produk.php" class="btn btn-primary">Kembali ke Produk</a>
<?php else: ?>

<?php
// === Bersihkan item yang tidak valid ===
foreach ($cart as $id => $qty) {
    $product = getProduct($conn, $id);
    if (!$product) {
        unset($_SESSION['cart'][$id]);
        continue;
    }

    // Tambahkan subtotal dan totalQty hanya jika produk valid
    $itemTotal = $product['harga'] * $qty;
    $subtotal += $itemTotal;
    $totalQty += $qty;
}
?>

  <h3>Shopping Cart</h3>
  <p>You have <?= $totalQty; ?> item(s) in your cart</p>

<div class="table-responsive">
  <table class="table cart-table align-middle">
    <thead>
      <tr>
        <th>Description</th>
        <th>Unit</th>
        <th>Price (Rp)</th>
        <th>Quantity</th>
        <th>Total (Rp)</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($_SESSION['cart'] as $id => $qty): 
        $product = getProduct($conn, $id);
        if (!$product) continue;
        $itemTotal = $product['harga'] * $qty;
      ?>
      <tr>
        <td>
          <div class="d-flex align-items-center gap-3">
            <img src="images/<?= htmlspecialchars($product['gambar']); ?>" alt="">
            <div><?= htmlspecialchars($product['nama_produk']); ?></div>
          </div>
        </td>
        <td><?= htmlspecialchars($product['satuan']); ?></td>
        <td>Rp <?= number_format($product['harga']); ?></td>
        <td><?= $qty; ?></td>
        <td>Rp <?= number_format($itemTotal); ?></td>
        <td>
          <form method="post" action="keranjang_hapus.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button type="submit" class="btn btn-sm btn-danger">&times;</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

  <!-- Kupon + Total -->
  <div class="row mt-4">
    <div class="col-md-6 coupon-box mb-3">
      <form method="post">
        <input type="text" name="coupon" class="form-control d-inline-block w-auto" placeholder="Coupon code" value="<?= htmlspecialchars($couponInput); ?>">
        <button class="btn btn-primary" type="submit">Apply Discount</button>
      </form>
    </div>

    <div class="col-md-6">
      <div class="summary-box">
        <?php $total = $subtotal - $appliedDiscount; ?>
        <div class="d-flex justify-content-between">
          <span>Discount</span>
          <strong>Rp <?= number_format($appliedDiscount); ?></strong>
        </div>
        <div class="d-flex justify-content-between">
          <span>Subtotal</span>
          <strong>Rp <?= number_format($subtotal); ?></strong>
        </div>
        <div class="d-flex justify-content-between fs-5 mt-2">
          <span>Total</span>
          <strong>Rp <?= number_format($total); ?></strong>
        </div>
        <br>
        <form action="pembayaran.php" method="get">
          <button type="submit" class="btn btn-danger w-100">
            Proceed to Checkout →
          </button>
        </form>
        <div class="mt-2 text-end">
          <a href="produk.php">Continue shopping</a>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
