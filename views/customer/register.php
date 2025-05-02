<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SI-SUPLY</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f0f0;
            background: url('../customer/images/bghomr.jpeg') no-repeat center center fixed;
            background-size: cover;
        }

        header {
            background-color: #7cc5f7;
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-title img {
            height: 40px;
        }

        .logo-title h1 {
            font-size: 24px;
            color: white;
            margin: 0;
        }

        .register-box {
      background-color: rgba(255,255,255,0.85);
      width: 400px;
      margin: 48px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .register-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .register-box img {
      display: block;
      margin: 0 auto 10px;
      width: 60px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .btn-register {
      width: 100%;
      padding: 10px;
      background-color: #73c2f9;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-register:hover {
      background-color: #57ace7;
    }
    </style>
</head>
<body>

<header>
  <?php include('../../parts/customer/navbar1.php'); ?>
</header>

<!-- Login Form -->
  <div class="register-box">
    <img src="images/logo.jpg" alt="Logo">
    <h2>Register</h2>

    <form action="home.php" method="POST">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Masukan Email" required>
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="Masukan Alamat" required>
      </div>

      <div class="form-group">
        <label>No. HP</label>
        <input type="text" name="no_hp" placeholder="Masukan No. HP" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password" required>
      </div>

      <button type="submit" class="btn-register">Register</button>
    </form>
  </div>

<?php include('../../parts/customer/footer.php'); ?>


</body>
</html>
