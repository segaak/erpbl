<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SI-SUPLY - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f6f7fb;
    }
    .navbar {
      background-color: #73c2f9;
    }
    .navbar-brand img {
      height: 35px;
      margin-right: 10px;
    }
    .navbar .btn {
      border-radius: 20px;
      padding: 5px 20px;
    }
    .hero {
      background-image: url('img/hero-banner.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 60px 0;
      text-align: center;
    }
    .search-bar {
      background: white;
      padding: 8px 15px;
      border-radius: 10px;
      max-width: 400px;
      margin: 20px auto;
    }
    .category-card {
      border-radius: 15px;
      background-color: #fff2d8;
      padding: 15px;
      text-align: center;
      transition: all 0.3s;
    }
    .category-card:hover {
      transform: translateY(-5px);
    }
    .product-card {
      background-color: white;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .product-card img {
      height: 100px;
      object-fit: contain;
      margin-bottom: 10px;
    }
    .btn-add {
      background-color: #f0ad4e;
      color: white;
      border: none;
      border-radius: 15px;
      padding: 5px 15px;
    }
    footer {
      background-color: #73c2f9;
      color: white;
      padding: 10px 0;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="#">
      <img src="img/logo.png" alt="Logo"> SI-SUPLY
    </a>
    <div class="ms-auto">
      <a href="#" class="btn btn-outline-light me-2">Register</a>
      <a href="#" class="btn btn-light text-primary">Login</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h2>Fresh Savings Every Week! Enjoy Up to 10% Off on Select Produce</h2>
      <p>Fresh fruits and vegetables, dairy products, snacks, beverages, household essentials.</p>
      <div class="search-bar">
        <input type="text" class="form-control" placeholder="Search for items...">
      </div>
      <a href="#" class="btn btn-light text-primary mt-2">Shop Now</a>
    </div>
  </section>

  <!-- Categories -->
  <section class="container my-5">
    <h5 class="mb-3">Explore Categories</h5>
    <div class="row g-3">
      <div class="col-4 col-md-2">
        <div class="category-card">
          <img src="img/fresh-produce.png" alt="Fresh Produce" class="img-fluid">
          <div class="mt-2">Fresh Produce</div>
        </div>
      </div>
      <div class="col-4 col-md-2">
        <div class="category-card">
          <img src="img/fresh-produce.png" alt="Fresh Produce" class="img-fluid">
          <div class="mt-2">Fresh Produce</div>
        </div>
      </div>
      <div class="col-4 col-md-2">
        <div class="category-card">
          <img src="img/fresh-produce.png" alt="Fresh Produce" class="img-fluid">
          <div class="mt-2">Fresh Produce</div>
        </div>
      </div>
      <div class="col-4 col-md-2">
        <div class="category-card">
          <img src="img/fresh-produce.png" alt="Fresh Produce" class="img-fluid">
          <div class="mt-2">Fresh Produce</div>
        </div>
      </div>
      <div class="col-4 col-md-2">
        <div class="category-card">
          <img src="img/fresh-produce.png" alt="Fresh Produce" class="img-fluid">
          <div class="mt-2">Fresh Produce</div>
        </div>
      </div>
      <!-- Tambahkan kategori lain sesuai kebutuhan -->
    </div>
  </section>

  <!-- Featured Products -->
  <section class="container mb-5">
    <h5 class="mb-3">Featured Products</h5>
    <div class="row g-4">
      <div class="col-6 col-md-3">
        <div class="product-card">
          <img src="img/pepper.png" alt="Pepper">
          <h6>Pepper 500g</h6>
          <p class="text-muted">Vegetable</p>
          <p><strong>Rp540</strong></p>
          <button class="btn btn-add w-100">+ Add</button>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="product-card">
          <img src="img/pepper.png" alt="Pepper">
          <h6>Pepper 500g</h6>
          <p class="text-muted">Vegetable</p>
          <p><strong>Rp540</strong></p>
          <button class="btn btn-add w-100">+ Add</button>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="product-card">
          <img src="img/pepper.png" alt="Pepper">
          <h6>Pepper 500g</h6>
          <p class="text-muted">Vegetable</p>
          <p><strong>Rp540</strong></p>
          <button class="btn btn-add w-100">+ Add</button>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="product-card">
          <img src="img/pepper.png" alt="Pepper">
          <h6>Pepper 500g</h6>
          <p class="text-muted">Vegetable</p>
          <p><strong>Rp540</strong></p>
          <button class="btn btn-add w-100">+ Add</button>
        </div>
      </div>
      <!-- Tambahkan produk lainnya -->
    </div>
  </section>

  <footer>
    Copyright ©SI-Suply 2024
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
