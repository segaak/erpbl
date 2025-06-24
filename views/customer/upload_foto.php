<?php
session_start();
include 'koneksi.php';

$username = $_SESSION['username'];

if (isset($_FILES['foto_profil'])) {
    $file = $_FILES['foto_profil'];
    $filename = basename($file['name']);
    $target_dir = "uploads/";
    $target_file = $target_dir . time() . "_" . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Simpan path file ke database
        $basename = basename($target_file);
        $stmt = $conn->prepare("UPDATE users SET foto_profil = ? WHERE username = ?");
        $stmt->bind_param("ss", $basename, $username);
        $stmt->execute();
    }
}

header("Location: profile.php");
exit;
