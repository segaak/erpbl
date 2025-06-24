<?php

$nama_pengguna = $_SESSION['username'] ?? 'Nama Pengguna';
$foto_profil = 'images/user-default.png';
?>

<style>
  header {
    background-color: #7cc5f7;
    padding: 8px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .logo img {
    height: 30px;
  }

  .logo h1 {
    font-size: 24px;
    color: white;
    font-weight: bold;
  }

  .search-form {
    flex: 1;
    display: flex;
    margin: 0 40px;
    max-width: 500px;
  }

  .search-form select,
  .search-form input {
    border: none;
    padding: 6px 10px;
    font-size: 14px;
    outline: none;
  }

  .search-form select {
    background-color: white;
  }

  .search-form input {
    flex-grow: 1;
  }

  .search-form button {
    background-color: #005f99;
    border: none;
    color: white;
    padding: 6px 12px;
    font-size: 14px;
    cursor: pointer;
  }

  .actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .actions button {
    background-color: white;
    color: #0077cc;
    border: none;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
  }

  .user-profile {
    display: flex;
    align-items: center;
    background-color: white;
    padding: 4px 8px;
    border-radius: 8px;
    gap: 10px;
    font-size: 13px;
  }

  .user-profile img {
    height: 24px;
    width: 24px;
    border-radius: 50%;
  }

  .user-profile span {
    color: #0077cc;
    font-weight: bold;
  }

  .dropdown-menu {
    font-size: 13px;
    min-width: 160px;
  }
</style>

<header>
  <div class="logo">
    <img src="images/logo.jpg" alt="Logo">
    <h1>SI-SUPPLY</h1>
  </div>

  <form class="search-form" action="search.php" method="GET">
  <select name="category">
  <option value="">Semua</option>
  <option value="gula">Gula</option>
  <option value="tepung">Tepung</option>
  <option value="minyak">Minyak</option>
  <option value="telur">Telur</option>
  <option value="beras">Beras</option>
  <option value="kecap">Kecap</option>
  <option value="susu">Susu</option>
  <option value="sabun">Sabun</option>
  <option value="makanan kaleng">Makanan Kaleng</option>
  <option value="minuman">Minuman</option>
  <option value="mie">Mie</option>
  <option value="pasta gigi">Pasta Gigi</option>
  <option value="tisu">Tisu</option>
</select>

    <input type="text" name="q" placeholder="Cari produk...">
    <button type="submit">🔍</button>
  </form>

  <div class="actions">
    <button>💚 Wishlist</button>
    <form action="keranjang.php" method="get">
  <button type="submit" class="btn btn-warning">🛒 My Cart</button>
</form>

    <div class="dropdown">
      <a class="user-profile dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?= htmlspecialchars($foto_profil) ?>" alt="Foto">
        <span><?= htmlspecialchars($nama_pengguna) ?></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="profile.php">👤 Cek Profil</a></li>
        <li><a class="dropdown-item" href="riwayat_pesanan.php">📦 Riwayat Pesanan</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </div>
</header>
