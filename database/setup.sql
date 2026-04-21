CREATE DATABASE IF NOT EXISTS dapur_kita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dapur_kita;

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

INSERT INTO resep (nama_resep, bahan, langkah, waktu_persiapkan, kategori)
SELECT 'Nasi Goreng Sederhana', 'Nasi putih, bawang putih, kecap manis, telur, garam', 'Panaskan minyak lalu tumis bawang putih. Masukkan telur dan orak-arik. Tambahkan nasi, kecap, dan garam. Aduk rata sampai matang.', '15 menit', 'Makanan Utama'
WHERE NOT EXISTS (SELECT 1 FROM resep WHERE nama_resep = 'Nasi Goreng Sederhana');

INSERT INTO resep (nama_resep, bahan, langkah, waktu_persiapkan, kategori)
SELECT 'Pisang Goreng Crispy', 'Pisang, tepung terigu, gula, air, minyak', 'Campur tepung, gula, dan air hingga jadi adonan. Celupkan pisang, lalu goreng hingga keemasan.', '20 menit', 'Camilan'
WHERE NOT EXISTS (SELECT 1 FROM resep WHERE nama_resep = 'Pisang Goreng Crispy');
