<?php
// Dapatkan nama file aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
  .nav-buttons {
    display: flex;
    gap: 10px;
  }

  .nav-buttons a {
    padding: 8px 15px;
    border: 2px solid white;
    border-radius: 15px;
    background-color: #7cc5f7;
    color: white;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .nav-buttons a:hover {
    background-color: white;
    color: #0077cc;
  }

  .nav-buttons a.active {
    background-color: white;
    color: #0077cc;
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

        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
            width: 400px;
            margin: 80px auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-box img {
            width: 60px;
            margin-bottom: 15px;
        }

        .login-box h2 {
            margin-bottom: 25px;
            color: #333;
        }
</style>
<div class="logo-title">
        <img src="images/logo.jpg" alt="Logo"> <!-- Ganti logo sesuai nama file -->
        <h1>SI-SUPLY</h1>
    </div>
<nav class="nav-buttons">
  <a 
    href="../../views/customer/login.php" 
    class="<?= ($current_page == 'login.php') ? 'active' : '' ?>"
  >
    Login
  </a>
  
  <a 
    href="../../views/customer/register.php" 
    class="<?= ($current_page == 'register.php') ? 'active' : '' ?>"
  >
    Register
  </a>
</nav>
