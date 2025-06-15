<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total_bayar']) || empty($_SESSION['cart'])) {
    header("Location: checkout.php");
    exit;
}

$_SESSION['metode_pembayaran'] = $_POST['metode_pembayaran'] ?? 'QRIS';
$_SESSION['total_bayar'] = (int)$_POST['total_bayar'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran via QR Code</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      padding: 30px;
    }
    .qr-container {
      max-width: 500px;
      margin: auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
      text-align: center;
    }
    .qr-image {
      max-width: 300px;
      width: 100%;
      height: auto;
      margin: 20px auto;
    }
    .instruction-box {
      background-color: #fff8dc;
      padding: 15px;
      border-radius: 10px;
      margin-top: 30px;
      text-align: left;
    }
    .choose-method {
      display: block;
      margin-top: 15px;
      text-align: left;
    }
    .choose-method a {
      text-decoration: none;
      color: #0d6efd;
      font-weight: 500;
    }
    .choose-method a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="qr-container">
    <h4>Scan untuk Membayar</h4>
    <p class="text-muted">Gunakan aplikasi <strong><?= htmlspecialchars($_SESSION['metode_pembayaran']) ?></strong></p>
    <img src="images/qr_sample.jpeg" alt="QR Code" class="qr-image">
    <h5 class="mt-4">Total: <strong>Rp<?= number_format($_SESSION['total_bayar'], 0, ',', '.') ?></strong></h5>

    <form action="bayar.php" method="post">
      <button type="submit" class="btn btn-success mt-3">Pay Now</button>
    </form>
  </div>

  <br>
  <div class="qr-container">
    <h6>Instruksi Pembayaran</h6>
    <ol class="mb-2 text-start">
      <li>Buka aplikasi QRIS (Gopay, OVO, Dana, dll)</li>
      <li>Scan kode QR di atas</li>
      <li>Periksa dan konfirmasi detail pembayaran</li>
      <li>Setelah berhasil, klik tombol di atas untuk melihat invoice</li>
    </ol>
    <div class="choose-method">
      <a href="pembayaran.php">&larr; Pilih Metode Pembayaran Lain</a>
    </div>
  </div>
</body>
</html>
