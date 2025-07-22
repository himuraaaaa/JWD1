<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan di URL.";
    exit;
}

$id = intval($_GET['id']);
$query = $koneksi->query("SELECT * FROM galeri WHERE id = $id");

if ($query->num_rows == 0 ) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = $query->fetch_assoc();
$fotoPath = 'assets/klien/' . $data['foto'];

// Hapus file foto kalau ada
if (file_exists($fotoPath)) {
    unlink($fotoPath);
}

// Hapus dari database
$koneksi->query("DELETE FROM galeri WHERE id = $id");

header("Location: uploadgaleri.php"); // Kembali ke galeri
exit;
?>
