<?php
include 'koneksi.php';

$statusFilter = $_GET['status'] ?? 'Semua';

$sql = "SELECT * FROM orders";
if ($statusFilter != 'Semua') {
    $sql .= " WHERE status = '$statusFilter'";
}
$sql .= " ORDER BY order_date DESC";

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #eaf6ff;
    }
    .tab-button {
      background: none;
      border: none;
      padding: 8px 16px;
      margin: 4px;
      border-radius: 10px;
      background-color: #f0f4fa;
      color: #000;
    }
    .tab-button.active {
      background-color: #008cff;
      color: #fff;
    }
    .card-transaksi {
      background-color: #fff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 15px;
    }
    .status-badge {
      background-color: #e8f0ff;
      color: #007bff;
      padding: 4px 10px;
      border-radius: 5px;
      font-size: 0.8rem;
    }
  </style>
</head>
<body>
  <?php include('../../parts/customer/navbar2.php');
 ?>
  <div class="container mt-4">
    <h5 class="fw-bold mb-3">Daftar Transaksi</h5>

    <div class="d-flex flex-wrap mb-4">
      <?php
      $statuses = ['Semua', 'Belum dibayar', 'Menunggu konfirmasi', 'Dikemas', 'Dikirim', 'Selesai'];
      foreach ($statuses as $status) {
          $active = ($statusFilter == $status) ? 'active' : '';
          echo "<form method='get'><input type='hidden' name='status' value='$status'><button type='submit' class='tab-button $active'>$status</button></form>";
      }
      ?>
    </div>

    <?php foreach ($orders as $order): ?>
      <div class="card-transaksi d-flex justify-content-between align-items-center">
        <div>
          <strong>🛒 Belanja</strong><br>
          <small><?= date('d F Y', strtotime($order['order_date'])) ?> - <?= $order['invoice_number'] ?></small><br>
          <a href="detail_transaksi.php?id=<?= $order['id'] ?>">Lihat Detail Transaksi</a>
        </div>
        <div class="text-end">
          <span class="status-badge"><?= $order['status'] ?></span><br>
          <span class="fw-bold">Total Belanja</span><br>
          <span>Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (count($orders) == 0): ?>
      <p class="text-muted text-center">Tidak ada transaksi untuk status ini.</p>
    <?php endif; ?>
  </div>
</body>
</html>