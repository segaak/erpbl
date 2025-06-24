<?php
include 'koneksi.php';
session_start();

$id = $_GET['id'] ?? 0;
$id = (int)$id;

// Ambil data pembayaran
$stmt = $conn->prepare("SELECT * FROM pembayaran WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$pembayaran = $stmt->get_result()->fetch_assoc();

if (!$pembayaran) {
    echo "Data pembayaran tidak ditemukan.";
    exit;
}

// Ambil item pesanan
$stmt = $conn->prepare("
    SELECT p.*, pr.nama_produk 
    FROM pesanan p
    JOIN produk pr ON p.id_produk = pr.ID_Produk
    WHERE p.id_pembayaran = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Set waktu dan tanggal
date_default_timezone_set('Asia/Jakarta');
$order_date = date('d F Y');
$order_time = date('H:i');

$ongkir = 50000;
$asuransi = 5000;
$total_tagihan = $pembayaran['total'];
$subtotal = $total_tagihan - $ongkir - $asuransi;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - SI-SUPLY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f7f9fb; }
        .invoice-card { border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card invoice-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <img src="assets/logo.png" alt="Logo" style="height: 50px;">
                <div class="text-end">
                    <h5 class="mb-1 fw-bold text-success">Invoice</h5>
                    <small class="text-muted">Order ID: #<?= $pembayaran['id'] ?></small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Tanggal & Waktu</h6>
                    <p class="mb-1"><?= $order_date ?> - <?= $order_time ?> WIB</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6>Metode Pembayaran</h6>
                    <p class="mb-1"><?= strtoupper($pembayaran['metode']) ?></p>
                </div>
            </div>

            <h6 class="fw-semibold mb-3">Detail Pesanan</h6>
            <table class="table table-sm table-borderless">
                <thead class="table-light">
                    <tr>
                        <th>Deskripsi</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                        <td class="text-end">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $item['jumlah'] ?></td>
                        <td class="text-end">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <div class="w-50">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-end fw-bold">Subtotal</td>
                            <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold">Ongkir</td>
                            <td class="text-end">Rp <?= number_format($ongkir) ?></td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold">Asuransi</td>
                            <td class="text-end">Rp <?= number_format($asuransi) ?></td>
                        </tr>
                        <tr class="table-light">
                            <td class="text-end fw-bold">Total Tagihan</td>
                            <td class="text-end fw-bold">Rp <?= number_format($total_tagihan, 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                    Cetak
                </button>
                <a href="riwayat_pesanan.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
