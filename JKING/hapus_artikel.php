<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak");
}
include 'Koneksi.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM artikel WHERE id = $id");

header("Location: kelola_artikel.php");
exit;
