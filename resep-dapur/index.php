<?php
session_start();
include 'inc/db.php';

if (!isset($_SESSION['favorit'])) {
    $_SESSION['favorit'] = [];
}

if (isset($_POST['simpan_id'])) {
    $idFavorit = (int)$_POST['simpan_id'];
    if (!in_array($idFavorit, $_SESSION['favorit'])) {
        $_SESSION['favorit'][] = $idFavorit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DapurKita</title>
  <link rel="stylesheet" href="assets/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="mobile-overlay" id="mobileOverlay"></div>
      <img src="assets/resep.jpg" alt="Logo DapurKita" class="logo">
      <section class="search-section">
        <input 
          type="text" 
          id="searchInput" 
          placeholder="Cari resep di sini..." 
          onkeyup="filterResep()">
        <ul id="searchDropdown" class="dropdown"></ul>
      </section>
      <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="nav-links" id="nav-links">
        <a href="index.php">Beranda</a>
        <a href="favorit.php">Favorit</a>
        <a href="#footer">Kontak</a>
        <a href="login.php" class="login-btn">Login</a>
        <a href="#" id="darkToggle" class="dark-mode-btn">Tema</a>
      </div>
    </nav>
  </header>

  <section>
    <div class="resep-container" id="resepContainer">
      <?php
        $query = "SELECT * FROM resep ORDER BY id DESC";  
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $isFavorit = isset($_SESSION['favorit']) && in_array($row['id'], $_SESSION['favorit']);
            $isFavorit = in_array($row['id'], $_SESSION['favorit']);

echo "
  <div class='resep-card' 
    data-nama='" . strtolower($row['nama_resep']) . "' 
    data-bahan='" . strtolower($row['bahan']) . "' 
    data-kategori='" . strtolower($row['kategori']) . "'>
    <h3>" . htmlspecialchars($row['nama_resep']) . "</h3>
    <p><strong>Bahan:</strong> " . htmlspecialchars(substr($row['bahan'], 0, 100)) . "...</p>
    <p><strong>Waktu Persiapan:</strong> " . ($row['waktu_persiapkan'] ? htmlspecialchars($row['waktu_persiapkan']) : "Tidak diketahui") . "</p>
    <p><strong>Kategori:</strong> " . htmlspecialchars($row['kategori']) . "</p>
    <a href='resep.php?id=" . $row['id'] . "'>Lihat Resep</a>

    <form method='post'>
      <input type='hidden' name='simpan_id' value='" . $row['id'] . "' />
      <button type='submit' class='back-link' style='margin-top: 0.5rem; background-color: " . ($isFavorit ? "#6c757d" : "#28a745") . "; color: white;'>
        " . ($isFavorit ? "✔ Disimpan" : " Simpan Resep") . "
      </button>
    </form>
  </div>
";

          }
        } else {
          echo "<p>Tidak ada resep yang ditemukan.</p>";
        }
      ?>
    </div>
  </section>

  <footer>
    <div class="footer-content" id="footer">
      <div class="footer-links">
        <h4>Menu</h4>
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li><a href="kategori.php">Kategori</a></li>
          <li><a href="favorit.php">Favorit</a></li>
          <li><a href="tentang.php">Tentang Kami</a></li>
          <li><a href="kontak.php">Kontak</a></li>
        </ul>
      </div>
      <div class="footer-social">
        <h4>Ikuti Kami</h4>
        <ul>
          <li><a href="https://facebook.com" target="_blank">Facebook</a></li>
          <li><a href="https://instagram.com" target="_blank">Instagram</a></li>
          <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
        </ul>
      </div>
      <div class="footer-about">
        <h4>Tentang DapurKita</h4>
        <p>DapurKita adalah platform resep makanan yang menawarkan berbagai resep mudah dan lezat.</p>
      </div>
    </div>
    
  </footer>

  <script src="assets/script.js"></script>
</body>
</html>
