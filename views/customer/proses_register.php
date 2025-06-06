<?php
include 'koneksi.php'; // Pastikan koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $alamat   = $_POST['alamat'];
    $no_hp    = $_POST['no_hp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $roles    = 'customer'; // roles diset otomatis

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (nama, username, email, alamat, no_hp, password, roles) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nama, $username, $email, $alamat, $no_hp, $password, $roles);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil!'); window.location.href='login.php';</script>";
    } else {
        echo "Gagal registrasi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
