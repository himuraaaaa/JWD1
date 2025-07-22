<?php
include 'Koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $isi        = mysqli_real_escape_string($conn, $_POST['isi']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $foto_lama  = $_POST['foto_lama'];
    $nama_file  = $foto_lama;

    // Proses upload foto baru jika ada
    if (!empty($_FILES['foto']['name'])) {
        $fileName = $_FILES['foto']['name'];
        $tmpName  = $_FILES['foto']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed)) {
            $folder = "uploads/";
            if (!is_dir($folder)) mkdir($folder);
            $nama_file = uniqid() . "." . $fileExt;

            move_uploaded_file($tmpName, $folder . $nama_file);

            // Hapus foto lama dari folder (optional)
            if (file_exists($folder . $foto_lama)) {
                unlink($folder . $foto_lama);
            }
        }
    }

    $sql = "UPDATE galeri SET 
                judul='$judul', 
                keterangan='$keterangan', 
                isi='$isi', 
                nama_file='$nama_file', 
                kategori='$kategori' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: foto-klien.php?edit=success");
        exit;
    } else {
        echo "<p style='color:red;'>❌ Gagal update data: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red;'>Permintaan tidak valid.</p>";
}
?>
