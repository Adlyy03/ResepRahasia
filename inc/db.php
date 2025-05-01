<?php
$servername = "localhost";  // Atau sesuaikan dengan host Anda
$username = "root";         // Atau sesuaikan dengan username Anda
$password = "";             // Atau sesuaikan dengan password Anda
$dbname = "dapur_kita";     // Atau sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
