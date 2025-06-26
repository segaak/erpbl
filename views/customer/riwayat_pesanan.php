<?php
include 'koneksi.php';
session_start();

// Ambil status filter dari URL (jika ada)
$statusFilter = $_GET['status'] ?? 'Semua';

// Query transaksi dari tabel pembayaran dan status dari salah satu pesanan
$sql = "
    SELECT 
        p.id,
        p.tanggal,
        p.total,
        p.metode,
        (
            SELECT status 
            FROM pesanan ps 
            WHERE ps.id_pembayaran = p.id 
            LIMIT 1
        ) as status
    FROM pembayaran p
";

// Filter berdasarkan status jika dipilih
if ($statusFilter !== 'Semua') {
    $statusFilterEscaped = $conn->real_escape_string($statusFilter);
    $sql .= " HAVING status = '$statusFilterEscaped'";
}

$sql .= " ORDER BY p.tanggal DESC";

// Jalankan query dan simpan hasil
$result = $conn->query($sql);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
  <?php include('../../parts/customer/navbar2.php'); ?>

  <div class="container mt-4">
      <div class="breadcrumb mb-4">
    <a href="produk.php">Home</a> > <a href="#">Cart</a>
  </div>
    <h5 class="fw-bold mb-3">Daftar Transaksi</h5>

    <!-- Filter status -->
    <div class="d-flex flex-wrap mb-4">
      <?php
      $statuses = ['Semua', 'Belum dibayar', 'Menunggu konfirmasi', 'Dikemas', 'Dikirim', 'Selesai'];
      foreach ($statuses as $status) {
          $active = ($statusFilter === $status) ? 'active' : '';
          echo "<form method='get' class='me-2 mb-2'>
                  <input type='hidden' name='status' value='$status'>
                  <button type='submit' class='tab-button $active'>$status</button>
                </form>";
      }
      ?>
    </div>

    <!-- Tampilkan Transaksi -->
    <?php if (count($orders) > 0): ?>
      <?php foreach ($orders as $order): ?>
        <div class="card-transaksi d-flex justify-content-between align-items-center">
          <div>
            <strong>🛒 Belanja</strong><br>
            <small><?= date('d F Y', strtotime($order['tanggal'])) ?> - INV#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></small><br>
            <a href="invoice.php?id=<?= $order['id'] ?>">Lihat Detail Transaksi</a>
          </div>
          <div class="text-end">
            <span class="status-badge"><?= $order['status'] ?? 'Belum ada status' ?></span><br>
            <span class="fw-bold">Total Belanja</span><br>
            <span>Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted text-center">Tidak ada transaksi untuk status ini.</p>
    <?php endif; ?>
  </div>
</body>
</html>
