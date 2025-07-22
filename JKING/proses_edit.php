<?php
session_start();
include 'Koneksi.php';

// Hanya admin yang boleh
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nama_file = mysqli_real_escape_string($conn, $_POST['nama_file']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $tanggal_upload = mysqli_real_escape_string($conn, $_POST['tanggal_upload']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Jika user upload gambar baru
    if (!empty($_FILES['foto_baru']['name'])) {
        $fileName = $_FILES['foto_baru']['name'];
        $tmpName = $_FILES['foto_baru']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        $folder = "uploads/";

        if (in_array($fileExt, $allowed)) {
            $newName = uniqid() . "." . $fileExt;
            move_uploaded_file($tmpName, $folder . $newName);

            // Update database dengan file baru
            $sql = "UPDATE galeri SET 
                        nama_file = '$newName', 
                        keterangan = '$keterangan', 
                        tanggal_upload = '$tanggal_upload',
                        kategori = '$kategori'
                    WHERE id = $id";
        } else {
            echo "❌ Format file tidak didukung!";
            exit;
        }
    } else {
        // Tidak ganti foto
        $sql = "UPDATE galeri SET 
                    nama_file = '$nama_file',
                    keterangan = '$keterangan',
                    tanggal_upload = '$tanggal_upload',
                    kategori = '$kategori'
                WHERE id = $id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: uploadgaleri.php?edit=success");
    } else {
        echo "❌ Gagal update: " . mysqli_error($conn);
    }
}
?>
