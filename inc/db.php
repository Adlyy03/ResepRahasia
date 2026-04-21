<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'dapur_kita';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error . '. Jalankan setup_database.php atau import database/setup.sql.');
}

$conn->set_charset('utf8mb4');
?>
