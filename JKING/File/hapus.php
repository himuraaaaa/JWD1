<?php
include '../Koneksi.php';
$id = $_GET['id'];

$result = $koneksi->query("SELECT nama_file FROM file_upload WHERE id=$id");
$row = $result->fetch_assoc();

if ($row) {
    $filePath = "../uploads/" . $row['nama_file'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    $koneksi->query("DELETE FROM file_upload WHERE id=$id");
}

header("Location: index.php");
