<?php
session_start();

// Pastikan ada ID yang dikirim melalui POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Hapus item dari session cart
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

// Kembali ke halaman keranjang
header("Location: keranjang.php");
exit;
