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
    // echo "Koneksi PDO berhasil!"; // Untuk debugging
} catch (PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}
?>

<?php
// ----------- KONEKSI MySQLi (prosedural) -----------
// Jika Anda tidak menggunakan PDO, aktifkan ini dan komentar PDO di atas
/*
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Gunakan ini
$db   = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT');

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi MySQLi prosedural gagal: " . mysqli_connect_error());
}
//echo "Koneksi MySQLi prosedural berhasil!";
*/
?>

<?php
// ----------- KONEKSI MySQLi (objek) -----------
// Jika Anda tidak menggunakan PDO atau mysqli prosedural, aktifkan ini dan komentar yang lain
/*
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Gunakan ini
$dbname = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT');

$koneksi = new mysqli($host, $user, $pass, $dbname, $port);

if ($koneksi->connect_error) {
    die("Koneksi MySQLi objek gagal: " . $koneksi->connect_error);
}
//echo "Koneksi MySQLi objek berhasil!";
*/
?>
