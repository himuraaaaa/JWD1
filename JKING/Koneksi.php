<?php
// ----------- KONEKSI PDO -----------
// Mengambil kredensial dari environment variables Railway
$host = getenv('MYSQL_HOST'); // mysql.railway.internal
$dbname = getenv('MYSQL_DATABASE'); // railway
$user = getenv('MYSQL_USER'); // root
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Password yang panjang dari dashboard
$port = getenv('MYSQL_PORT'); // 3306

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    // Set PDO error mode to exception untuk penanganan error yang lebih baik
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Koneksi PDO berhasil!"; // Untuk debugging, bisa dihapus nanti
} catch (PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}
?>

<?php
// ----------- KONEKSI MySQLi (prosedural) -----------
// Mengambil kredensial dari environment variables Railway
$host = getenv('MYSQL_HOST'); // mysql.railway.internal
$user = getenv('MYSQL_USER'); // root
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Password yang panjang
$db   = getenv('MYSQL_DATABASE'); // railway
$port = getenv('MYSQL_PORT'); // 3306

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi MySQLi prosedural gagal: " . mysqli_connect_error());
}
//echo "Koneksi MySQLi prosedural berhasil!"; // Untuk debugging, bisa dihapus nanti
?>

<?php
// ----------- KONEKSI MySQLi (objek) -----------
// Mengambil kredensial dari environment variables Railway
$host = getenv('MYSQL_HOST'); // mysql.railway.internal
$user = getenv('MYSQL_USER'); // root
$pass = getenv('MYSQL_ROOT_PASSWORD'); // Password yang panjang
$dbname = getenv('MYSQL_DATABASE'); // railway
$port = getenv('MYSQL_PORT'); // 3306

$koneksi = new mysqli($host, $user, $pass, $dbname, $port);

if ($koneksi->connect_error) {
    die("Koneksi MySQLi objek gagal: " . $koneksi->connect_error);
}
//echo "Koneksi MySQLi objek berhasil!"; // Untuk debugging, bisa dihapus nanti
?>
