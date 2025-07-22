<?php
// ----------- KONEKSI PDO -----------
// Mengambil MYSQL_URL dari environment variables Railway
$mysql_url = getenv('MYSQL_URL');

// Mem-parse URL untuk mendapatkan komponen-komponennya
$url_components = parse_url($mysql_url);

$host = $url_components['host'];
$dbname = ltrim($url_components['path'], '/'); // Menghapus slash di awal path
$user = $url_components['user'];
$pass = $url_components['pass'];
$port = $url_components['port'];

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
// Ini akan menggunakan kredensial dari MYSQL_HOST dll. seperti sebelumnya
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_ROOT_PASSWORD');
$db   = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT');

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi MySQLi prosedural gagal: " . mysqli_connect_error());
}
//echo "Koneksi MySQLi prosedural berhasil!";
?>

<?php
// ----------- KONEKSI MySQLi (objek) -----------
// Ini akan menggunakan kredensial dari MYSQL_HOST dll. seperti sebelumnya
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_ROOT_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT');

$koneksi = new mysqli($host, $user, $pass, $dbname, $port);

if ($koneksi->connect_error) {
    die("Koneksi MySQLi objek gagal: " . $koneksi->connect_error);
}
//echo "Koneksi MySQLi objek berhasil!";
?>
