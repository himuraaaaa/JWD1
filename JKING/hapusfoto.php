<?php
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
include 'Koneksi.php';

// Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan di URL.";
    exit;
}

$id = intval($_GET['id']); // Pastikan ID adalah integer dan aman

// --- Langkah 1: Ambil nama file foto dari database ---
$sql_select = "SELECT nama_file FROM galeri WHERE id = ?";
$stmt_select = $pdo->prepare($sql_select);
$stmt_select->execute([$id]);

// Cek apakah data ditemukan
if ($stmt_select->rowCount() == 0) {
    echo "Data galeri tidak ditemukan.";
    exit;
}

$data = $stmt_select->fetch(PDO::FETCH_ASSOC);
$nama_file_foto = $data['nama_file']; // Ambil nama file foto

// Tentukan jalur lengkap ke file foto (disesuaikan dengan folder 'uploads/')
$fotoPath = 'uploads/' . $nama_file_foto; // Diperbaiki dari 'assets/klien/' menjadi 'uploads/'

// --- Langkah 2: Hapus file foto dari server ---
if (file_exists($fotoPath)) {
    if (unlink($fotoPath)) {
        //echo "Foto berhasil dihapus dari server.<br>"; // Pesan debugging opsional
    } else {
        //echo "Gagal menghapus foto dari server.<br>"; // Pesan debugging opsional
        // Anda bisa memutuskan untuk tetap menghapus dari DB meskipun file gagal dihapus
    }
} else {
    //echo "File foto tidak ditemukan di server: " . $fotoPath . "<br>"; // Pesan debugging opsional
}

// --- Langkah 3: Hapus dari database ---
$sql_delete = "DELETE FROM galeri WHERE id = ?";
$stmt_delete = $pdo->prepare($sql_delete);

if ($stmt_delete->execute([$id])) {
    //echo "Data berhasil dihapus dari database.<br>"; // Pesan debugging opsional
    header("Location: kelolagaleri.php?hapus=success"); // Kembali ke kelolagaleri.php atau halaman yang sesuai
    exit;
} else {
    $errorInfo = $stmt_delete->errorInfo();
    echo "Gagal menghapus dari database: " . $errorInfo[2];
    exit;
}
?>