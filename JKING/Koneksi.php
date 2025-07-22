<?php
// ----------- KONEKSI PDO (Menggunakan variabel lingkungan individual) -----------
// Ini adalah metode paling handal jika MYSQL_URL bermasalah
$host = getenv('MYSQLHOST');
$dbname = getenv('MYSQL_DATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Gunakan ini karena ini password root yang Anda miliki
$port = getenv('MYSQLPORT');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi PDO berhasil!"; // Untuk debugging - PASTIKAN INI DIKOMENTARI
} catch (PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}

// Pastikan tidak ada karakter apa pun setelah baris ini, termasuk spasi atau baris kosong.