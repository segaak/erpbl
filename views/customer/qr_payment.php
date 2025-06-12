<?php
// Validasi input
$total = $_POST['total_bayar'] ?? 0;
$metode = $_POST['metode_pembayaran'] ?? 'GoPay';

// QR code sesuai metode
$qrImage = 'images/qr_sample.jpeg'; // Default
switch (strtolower($metode)) {
    case 'bca virtual account':
        $qrImage = 'images/qr_bca.jpeg';
        break;
    case 'alfamart':
        $qrImage = 'images/qr_alfamart.jpeg';
        break;
    case 'gopay':
        $qrImage = 'images/qr_gopay.jpeg';
        break;
    // Tambahkan lagi jika perlu
}
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
      max-width: 400px;
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
  </style>
</head>
<body>
  <div class="qr-container">
    <h4>Scan untuk Membayar</h4>
    <p class="text-muted">Gunakan aplikasi <strong><?= htmlspecialchars($metode) ?></strong></p>
    
    <img src="<?= htmlspecialchars($qrImage); ?>" alt="QR Code" class="qr-image">

    <h5 class="mt-4">Total: <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></h5>

    <p class="text-muted mt-3">Setelah pembayaran berhasil, silakan tunggu konfirmasi otomatis atau kembali ke halaman utama.</p>

    <a href="produk.php" class="btn btn-primary mt-3">Kembali ke Beranda</a>
  </div>
</body>
</html>
