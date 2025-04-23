<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register | SI-SUPLY</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }

    body {
      background: url('images/bghomr.jpeg') no-repeat center center fixed;
      background-size: cover;
    }

    .navbar {
  background-color: #73c2f9;
  padding: 10px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
  color: white;
  font-weight: bold;
  font-size: 20px;
}

.logo img {
  height: 35px;
  margin-right: 10px;
}

.nav-buttons {
  display: flex;
  gap: 10px;
}

.nav-btn {
  background-color: transparent;
  color: white;
  border: 2px solid white;
  padding: 8px 16px;
  border-radius: 15px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}

.nav-btn:hover {
  background-color: white;
  color: #6ec1ff;
}

.nav-btn.active {
  background-color: white;
  color: #6ec1ff;
}


    .register-box {
      background-color: rgba(255,255,255,0.85);
      width: 400px;
      margin: 50px auto;
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

    footer {
      text-align: center;
      background-color: #73c2f9;
      color: white;
      padding: 10px;
      font-size: 12px;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="logo">
    <img src="images/logo.jpg" alt="Logo">
    <span>SI-SUPLY</span>
  </div>
  <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
  <div class="nav-buttons">
    <a href="register.php" class="nav-btn <?= $current_page == 'register.php' ? 'active' : '' ?>">Register</a>
    <a href="login.php" class="nav-btn <?= $current_page == 'login.php' ? 'active' : '' ?>">Login</a>
  </div>
</div>


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

  <footer>
    Copyright © SI-Suply 2024
  </footer>

</body>
</html>
