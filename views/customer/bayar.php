<?php
session_start();
include 'koneksi.php';

if (empty($_SESSION['cart']) || !isset($_SESSION['total_bayar'], $_SESSION['metode_pembayaran'])) {
    header("Location: checkout.php");
    exit;
}

$metode = $_SESSION['metode_pembayaran'];
$total = $_SESSION['total_bayar'];
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

// Hapus keranjang
unset($_SESSION['cart']);

// Hapus sesi metode dan total
unset($_SESSION['total_bayar'], $_SESSION['metode_pembayaran']);

// Redirect ke invoice
header("Location: invoice.php?id=$id_pembayaran");
exit;
?>
