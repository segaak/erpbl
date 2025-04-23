<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | SI-SUPLY</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
    }

    body {
      background: url('img/bg-login.png') no-repeat center center fixed;
      background-size: cover;
    }

    .navbar {
      background-color: #73c2f9;
      padding: 10px 30px;
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

    .nav-buttons a {
      background-color: transparent;
      color: white;
      border: 2px solid white;
      padding: 6px 14px;
      border-radius: 15px;
      margin-left: 10px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .nav-buttons a.active,
    .nav-buttons a:hover {
      background-color: white;
      color: #6ec1ff;
    }

    .login-box {
      background-color: rgba(255,255,255,0.95);
      width: 400px;
      margin: 80px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
    }

    .login-box img {
      width: 60px;
      margin-bottom: 15px;
    }

    .login-box h2 {
      margin-bottom: 20px;
      font-weight: bold;
      font-size: 22px;
      color: #333;
    }

    .form-group {
      text-align: left;
      margin-bottom: 15px;
    }

    .form-group label {
      font-weight: bold;
      font-size: 14px;
      display: block;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .btn-login {
      width: 100%;
      padding: 10px;
      background-color: #73c2f9;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }

    .btn-login:hover {
      background-color: #57ace7;
    }

    .register-link {
      margin-top: 10px;
      font-size: 13px;
    }

    .register-link a {
      color: #007bff;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
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

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">
      <img src="img/logo.png" alt="Logo">
      SI-SUPLY
    </div>
    <div class="nav-buttons">
      <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
      <a href="register.php" class="<?= $current_page == 'register.php' ? 'active' : '' ?>">Register</a>
      <a href="login.php" class="<?= $current_page == 'login.php' ? 'active' : '' ?>">Login</a>
    </div>
  </div>

  <!-- Login Form -->
  <div class="login-box">
    <img src="img/logo.png" alt="Logo">
    <h2>Login</h2>
    <form action="proses_login.php" method="post">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password" required>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="register-link">
      Belum punya akun? <a href="register.php">Register</a>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    Copyright © SI-Suply 2024
  </footer>

</body>
</html>
