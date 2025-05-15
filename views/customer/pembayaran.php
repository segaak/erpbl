<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - SI-SUPLY</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f6f7fb; }
    .section-box {
      background-color: white;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .btn-checkout {
      background-color: #4db6ff;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
    }
    .summary-table td {
      padding: 5px 0;
    }
    .summary-table td:last-child {
      text-align: right;
    }
    .address-box {
      font-size: 14px;
    }
  </style>
</head>
<body>

<?php include('../../parts/customer/navbar2.php'); ?>

<div class="container mt-4 mb-5">
<div class="breadcrumb mb-3">
    <a href="produk.php">Home</a> > <a href="#">Product</a>
  </div>
  <h5 class="mb-3">Checkout</h5>
  
  <div class="row">
    <!-- Left side -->
    <div class="col-md-7">
      <div class="section-box address-box mb-3">
        <strong>ALAMAT PENGIRIMAN</strong> <br>
        Rumah<br>
        Jl. Babarsari Jl. Tambak Bayan No.3, Janti, Caturtunggal, Kec. Depok, <br>
        Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281
        <button class="btn btn-sm btn-outline-secondary float-end">Ganti</button>
      </div>

      <div class="section-box">
        <h6>Cart</h6>
        <table class="table table-borderless align-middle">
          <thead>
            <tr>
              <th>Description</th>
              <th>Price (Rp)</th>
              <th>Quantity</th>
              <th>Total (Rp)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Beras 5 kg</td>
              <td>Rp. 100.000</td>
              <td>3</td>
              <td>Rp. 300.000</td>
            </tr>
            <tr>
              <td>Gula 1 kg</td>
              <td>Rp. 30.000</td>
              <td>1</td>
              <td>Rp. 30.000</td>
            </tr>
            <tr>
              <td>Kentang 1 kg</td>
              <td>Rp. 21.000</td>
              <td>7</td>
              <td>Rp. 147.000</td>
            </tr>
          </tbody>
        </table>

        <div class="d-flex align-items-center">
          <input type="text" class="form-control me-2" placeholder="Suppli2024" style="max-width: 200px;">
          <button class="btn btn-primary">Apply Discount</button>
          <div class="ms-auto">
            Discount <strong>Rp. 22.000</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Right side -->
    <div class="col-md-5">
      <div class="section-box">
        <h6>Metode Pembayaran <a href="#" class="float-end text-decoration-none small">Lihat Semua</a></h6>
        <div class="mb-3">
          <img src="img/bca-va.png" alt="BCA VA" height="24"> BCA Virtual Account<br>
          <small class="text-muted">Mudah & terverifikasi otomatis</small>
        </div>
        <div class="mb-3">
          <img src="img/alfamart.png" alt="Alfamart" height="24"> Alfamart / Lawson / Dan+Dan<br>
          <small class="text-muted">Bayar di kasir di seluruh minimarket</small>
        </div>

        <hr>

        <h6>Cek Ringkasan transaksimu, yuk</h6>
        <table class="summary-table w-100">
          <tr>
            <td>Total Harga (3 barang)</td>
            <td>Rp 450.000</td>
          </tr>
          <tr>
            <td>Total Ongkos Kirim</td>
            <td>Rp 50.000</td>
          </tr>
          <tr>
            <td>Total Asuransi Pengiriman</td>
            <td>Rp 5.000</td>
          </tr>
          <tr>
            <td>Total Lainnya</td>
            <td>Rp 0</td>
          </tr>
          <tr class="fw-bold">
            <td>Total Tagihan</td>
            <td>Rp 505.000</td>
          </tr>
        </table>

        <a href="pembayaran_berhasil.php" class="btn btn-checkout mt-3">Bayar Sekarang</a>
        <p class="small text-muted mt-2 text-center">
          Dengan melanjutkan pembayaran, kamu menyetujui S&K <br> Asuransi Pengiriman & Proteksi
        </p>
      </div>
    </div>
  </div>
</div>

<footer class="text-center text-white bg-primary py-2">
  © SI-SUPLY 2024
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
