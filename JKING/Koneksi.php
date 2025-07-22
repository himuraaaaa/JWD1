<?php
$host = "localhost";
$dbname = "jking_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jking_db"; // <- SESUAIKAN DENGAN DATABASE YANG BENAR

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<?php
$koneksi = new mysqli("localhost", "root", "", "jking_db");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

