<?php
session_start();
include 'koneksi.php';

$id_produk = $_POST['id_produk'];
$quantity = $_POST['quantity'] ?? 1;

// Inisialisasi cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah ke cart (jika sudah ada, tambahkan jumlahnya)
if (isset($_SESSION['cart'][$id_produk])) {
    $_SESSION['cart'][$id_produk] += $quantity;
} else {
    $_SESSION['cart'][$id_produk] = $quantity;
}

header('Location: keranjang.php');
exit;
