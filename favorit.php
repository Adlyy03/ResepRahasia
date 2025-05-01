<?php
session_start();
include 'inc/db.php';

if (!isset($_SESSION['favorit'])) {
  $_SESSION['favorit'] = [];
}

// Tangani aksi hapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
  $hapus_id = intval($_POST['hapus_id']);
  $_SESSION['favorit'] = array_diff($_SESSION['favorit'], [$hapus_id]);
}

// Ambil data resep favorit
$favorit = $_SESSION['favorit'];
$resep_list = [];

if ($favorit) {
  $id_list = implode(',', array_map('intval', $favorit));
  $result = mysqli_query($conn, "SELECT * FROM resep WHERE id IN ($id_list)");
  while ($row = mysqli_fetch_assoc($result)) {
    $resep_list[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Resep Favorit - DapurKita</title>
  <link rel="stylesheet" href="assets/favorit.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <h1>Resep Favorit</h1>
    <a href="index.php" class="back-link">← Kembali</a>
  </header>

  <main>
    <?php if ($resep_list): ?>
      <ul>
        <?php foreach ($resep_list as $resep): ?>
          <li>
            <a href="resep.php?id=<?= $resep['id'] ?>">
              <?= htmlspecialchars($resep['nama_resep']) ?>
            </a>
            <form method="post" style="margin-top: 0.5rem;">
              <input type="hidden" name="hapus_id" value="<?= $resep['id'] ?>">
              <button type="submit" class="hapus-btn">🗑 Hapus</button>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>Belum ada resep yang disimpan.</p>
    <?php endif; ?>
  </main>
</body>
</html>
