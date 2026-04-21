<?php
include 'inc/db.php';

// 1. Ambil dan validasi ID dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
  echo "<p>ID resep tidak valid.</p>";
  exit;
}

// 2. Siapkan query dengan prepared statement
$stmt = $conn->prepare("SELECT * FROM resep WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// 3. Cek apakah query berhasil dan data ada
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>Resep dengan ID {$id} tidak ditemukan.</p>";
    exit;
}

$resep = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= htmlspecialchars($resep['nama_resep']); ?> - DapurKita</title>
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cal+Sans&family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <h1><?= htmlspecialchars($resep['nama_resep']); ?></h1>
    <a href="index.php" class="back-link">← Kembali</a>
  </header>

  <main>
    <section class="recipe-details">
      <div class="info">
        <h2>Detail Resep</h2>

        
        <h3>Bahan-bahan:</h3>
        <ul>
          <?php
            // setiap bahan dipisah koma
            $arrBahan = explode(',', $resep['bahan']);
            foreach ($arrBahan as $item) {
              echo '<li>' . htmlspecialchars(trim($item)) . '</li>';
            }
          ?>
        </ul>

        <h3>Cara Memasak:</h3>
        <p><?= nl2br(htmlspecialchars($resep['langkah'])); ?></p>

        <p><strong>Kategori:</strong> <?= htmlspecialchars($resep['kategori']); ?></p>
        <p><strong>Waktu Persiapan:</strong> <?= htmlspecialchars($resep['waktu_persiapkan']); ?></p>

      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 DapurKita</p>
  </footer>
</body>
</html>
