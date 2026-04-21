<?php
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'dapur_kita';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die('Koneksi MySQL gagal: ' . $conn->connect_error);
}

if (!$conn->query("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die('Gagal membuat database: ' . $conn->error);
}

if (!$conn->select_db($dbName)) {
    die('Gagal memilih database: ' . $conn->error);
}

$createTableSql = "
CREATE TABLE IF NOT EXISTS resep (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_resep VARCHAR(255) NOT NULL,
    bahan TEXT NOT NULL,
    langkah TEXT NOT NULL,
    waktu_persiapkan VARCHAR(100) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if (!$conn->query($createTableSql)) {
    die('Gagal membuat tabel resep: ' . $conn->error);
}

$seedOne = "
INSERT INTO resep (nama_resep, bahan, langkah, waktu_persiapkan, kategori)
SELECT 'Nasi Goreng Sederhana', 'Nasi putih, bawang putih, kecap manis, telur, garam', 'Panaskan minyak lalu tumis bawang putih. Masukkan telur dan orak-arik. Tambahkan nasi, kecap, dan garam. Aduk rata sampai matang.', '15 menit', 'Makanan Utama'
WHERE NOT EXISTS (SELECT 1 FROM resep WHERE nama_resep = 'Nasi Goreng Sederhana')
";

$seedTwo = "
INSERT INTO resep (nama_resep, bahan, langkah, waktu_persiapkan, kategori)
SELECT 'Pisang Goreng Crispy', 'Pisang, tepung terigu, gula, air, minyak', 'Campur tepung, gula, dan air hingga jadi adonan. Celupkan pisang, lalu goreng hingga keemasan.', '20 menit', 'Camilan'
WHERE NOT EXISTS (SELECT 1 FROM resep WHERE nama_resep = 'Pisang Goreng Crispy')
";

if (!$conn->query($seedOne) || !$conn->query($seedTwo)) {
    die('Gagal menambahkan data awal: ' . $conn->error);
}

echo 'Setup database selesai. Database dan tabel resep siap dipakai.';
