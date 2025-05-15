<?php


// Simulasi cart (data dari $_SESSION biasanya)
$cart = $_SESSION['cart'] ?? [];

// Fungsi untuk ambil data produk dari database
function getProduct($conn, $id) {
  $query = mysqli_query($conn, "SELECT * FROM produk WHERE ID_Produk = $id");
  return mysqli_fetch_assoc($query);
}

// Simulasi kupon
$discountCode = 'suppli2024';
$discountAmount = 22000;

$total = 0;
$subtotal = 0;

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
    <a href="index.php">Home</a> > <a href="#">Cart</a>
  </div>

  <h3>Shopping Cart</h3>
  <p>You have <?= count($cart); ?> item(s) in your cart</p>

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
        <?php foreach ($cart as $id => $qty): 
          $product = getProduct($conn, $id);
          $itemTotal = $product['harga'] * $qty;
          $subtotal += $itemTotal;
        ?>
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <img src="img/<?= $product['gambar']; ?>" alt="">
              <div><?= $product['nama_produk']; ?></div>
            </div>
          </td>
          <td><?= $product['satuan']; ?></td>
          <td>Rp <?= number_format($product['harga']); ?></td>
          <td>
            <div class="qty-box">
              <button>-</button>
              <input type="text" value="<?= $qty; ?>" readonly>
              <button>+</button>
            </div>
          </td>
          <td>Rp <?= number_format($itemTotal); ?></td>
          <td><span class="remove-item">&times;</span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Kupon + Total -->
  <div class="row mt-4">
    <div class="col-md-6 coupon-box mb-3">
      <form method="post">
        <input type="text" name="coupon" class="form-control d-inline-block w-auto" placeholder="Coupon code" value="<?= $_POST['coupon'] ?? ''; ?>">
        <button class="btn btn-primary" type="submit">Apply Discount</button>
      </form>
    </div>

    <div class="col-md-6">
      <div class="summary-box">
        <?php
        $appliedDiscount = 0;
        if (isset($_POST['coupon']) && $_POST['coupon'] === $discountCode) {
          $appliedDiscount = $discountAmount;
        }

        $total = $subtotal - $appliedDiscount;
        ?>
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
</div>

</body>
</html>
