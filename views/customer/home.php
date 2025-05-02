<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SI-SUPLY</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('../customer/images/bghomr.jpeg') no-repeat center center fixed;
            background-color: #f0f0f0;
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
       


        .hero {
            position: relative;
            background-image: url('bghomr.jpeg'); /* Ganti dengan gambar background kamu */
            background-size: cover;
            background-position: center;
            height: 86vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
        }
        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-content h2 {
            font-size: 60px;
            margin-bottom: 0;
            text-shadow: 2px 2px 4px #000;
        }
        .hero-content h3 {
            font-size: 40px;
            margin-top: 0;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px #000;
        }
        .hero-content p {
            font-size: 20px;
            color: white;
            background-color: rgba(0, 0, 0, 0.3);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
        }
       
    </style>
</head>
<body>

<header>
<?php include('../../parts/customer/navbar1.php'); ?>
</header>

<div class="hero" style="background-image: url('images/bghomr.jpeg');"> <!-- Ganti dengan gambar sesuai -->
    <div class="hero-content">
        <img src="images/logo.jpg" alt="Logo" width="300"><br><br>
        <h2>SELAMAT DATANG!</h2>
        <h3>di SI-SUPLY</h3>
        <p>Pusatnya tempat pencarian barang-barang grosir dan eceran</p>
    </div>
</div>



<?php include('../../parts/customer/footer.php'); ?>


</script>
</body>
</html>
