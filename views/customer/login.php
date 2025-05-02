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

      

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background-color: #7cc5f7;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #56a9d8;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

   
    </style>
</head>
<body>

<header>
  <?php include('../../parts/customer/navbar1.php'); ?>
</header>
<!-- Login Form -->
<div class="login-box">
    <img src="images/logo.jpg" alt="Logo">
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

<?php include('../../parts/customer/footer.php'); ?>


</body>
</html>
