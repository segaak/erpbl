<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total_bayar']) || empty($_SESSION['cart'])) {
    header("Location: pembayaran.php");
    exit;
}

$_SESSION['metode_pembayaran'] = $_POST['metode_pembayaran'] ?? 'BNI';
$_SESSION['total_bayar'] = (int)$_POST['total_bayar'];

// Simulasi nomor VA dan batas waktu
$virtual_account = '0217 082 1192 8543 6';
$deadline = date('d F Y, H.i', strtotime('+1 day'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Instruksi Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
     background-color: #f9f9f9;
      padding: 30px;
      font-family: 'Segoe UI', sans-serif;
    }
    .payment-box {
      max-width: 600px;
      margin: auto;
    background: white
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 40px 30px;
      text-align: center;
    }
    .va-number {
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 2px;
      margin-top: 15px;
    }
    .bank-logo {
      margin: 10px 0;
    }
    .expiry {
      margin-top: 20px;
      color: #666;
      font-size: 14px;
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
  <div class="payment-box">
    <p class="mb-1 text-muted">Payment Total:</p>
    <h2 class="fw-bold text-dark">Rp<?= number_format($_SESSION['total_bayar'], 0, ',', '.') ?></h2>

    <div class="bank-logo">
      <img src="images/logobca.png" alt="BCA" height="24">
    </div>

    <p class="text-muted mt-3">Virtual Account Number</p>
    <div class="va-number"><?= $virtual_account ?></div>
    <p class="text-muted small mt-1">Only accept from Bank BCA</p>

    <p class="expiry">Valid until : <?= $deadline ?></p>
       <form action="bayar.php" method="post">
      <button type="submit" class="btn btn-success mt-3">Pay Now</button>
    </form>
  </div>
  <br>
  <div class="qr-container">
    <h6>Instruksi Pembayaran</h6>
     <ol class="list-decimal pl-5 space-y-2 text-sm">
                <li>Login to your Bank BCA Mobile Banking app or Internet Banking</li>
                <li>Select "Transfer" or "Payment" menu</li>
                <li>Choose "Virtual Account" option</li>
                <li>Enter the virtual account number: <?= $virtual_account ?></li>
                <li>Confirm the payment details and complete the transaction</li>
                <li>Save your payment receipt</li>
            </ol>
    <div class="choose-method">
      <a href="pembayaran.php">&larr; Pilih Metode Pembayaran Lain</a>
    </div>
  </div>
</body>
</html>
