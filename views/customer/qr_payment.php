<?php
session_start();
include 'koneksi.php';

// Cek validitas permintaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total_bayar']) || empty($_SESSION['cart'])) {
    header("Location: checkout.php");
    exit;
}

// Ambil data
$metode = $_POST['metode_pembayaran'] ?? 'QRIS';
$total = (int)$_POST['total_bayar'];
$tanggal = date('Y-m-d H:i:s');

// Simpan ke tabel pembayaran
$stmt = $conn->prepare("INSERT INTO pembayaran (metode, total, tanggal) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $metode, $total, $tanggal);
$stmt->execute();
$id_pembayaran = $conn->insert_id;

// Simpan ke tabel pesanan
foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
    $produk = $conn->query("SELECT harga FROM produk WHERE ID_Produk = $id_produk")->fetch_assoc();
    if (!$produk) continue;

    $harga_satuan = (int)$produk['harga'];
    $subtotal = $harga_satuan * $jumlah;

    $stmt = $conn->prepare("INSERT INTO pesanan (id_pembayaran, id_produk, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiii", $id_pembayaran, $id_produk, $jumlah, $harga_satuan, $subtotal);
    $stmt->execute();
}

// Reset keranjang belanja
unset($_SESSION['cart']);

// Simulasi gambar QR Code (gantilah dengan QR generator nyata kalau diperlukan)
$qrImage = "img/qr-placeholder.png"; // contoh statis
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
    <p class="text-muted">Gunakan aplikasi <strong><?= htmlspecialchars($metode) ?></strong></p>

    <img src="<?= htmlspecialchars($qrImage); ?>" alt="QR Code" class="qr-image">

    <h5 class="mt-4">Total: <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></h5>

    <p class="text-muted mt-3">Setelah pembayaran berhasil, klik tombol di bawah untuk melihat invoice Anda.</p>

    <a href="invoice.php?id=<?= $id_pembayaran ?>" class="btn btn-success mt-3">Lihat Invoice</a>
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
      <a href="checkout.php">&larr; Pilih Metode Pembayaran Lain</a>
    </div>
  </div>
</body>
</html>
