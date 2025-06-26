<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['roles'] = $user['roles'];

            // Arahkan berdasarkan roles
            if ($user['roles'] == 'admin') {
                header("Location: http://localhost:8080/"); // admin
            } else if ($user['roles'] == 'customer') {
                header("Location: ../customer/produk.php"); // user
            }else if ($user['roles'] == 'owner') {
                header("Location: http://localhost:8080/ownerdashboard"); // owner
            } else {
                echo "<script>alert('Role tidak dikenali'); window.location.href='login.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Password salah'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan'); window.location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
