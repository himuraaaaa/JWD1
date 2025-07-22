<?php
session_start();
include 'Koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $kategori = 'klien'; // karena hanya ada kategori klien

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $fileName = $_FILES['foto']['name'];
        $tmpName = $_FILES['foto']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed)) {
            $folder = "uploads/";
            if (!is_dir($folder)) mkdir($folder);
            $newName = uniqid() . "." . $fileExt;

            if (move_uploaded_file($tmpName, $folder . $newName)) {
                $sql = "INSERT INTO galeri (judul, nama_file, keterangan, isi, kategori)
                        VALUES ('$judul', '$newName', '$keterangan', '$isi', '$kategori')";
                if (mysqli_query($conn, $sql)) {
                    $pesan = "<p style='color:green;'>✅ Foto berhasil diupload!</p>";
                } else {
                    $pesan = "<p style='color:red;'>❌ Gagal simpan ke database: " . mysqli_error($conn) . "</p>";
                }
            } else {
                $pesan = "<p style='color:red;'>❌ Gagal memindahkan file!</p>";
            }
        } else {
            $pesan = "<p style='color:red;'>❌ Format file tidak didukung!</p>";
        }
    } else {
        $pesan = "<p style='color:red;'>❌ Foto belum dipilih!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Galeri Klien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Upload Galeri Klien</h2>
        <?= $pesan ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Judul:</label>
            <input type="text" name="judul" required>

            <label>Keterangan:</label>
            <input type="text" name="keterangan" required>

            <label>Isi:</label>
            <textarea name="isi" rows="5" required></textarea>

            <label>Upload Foto:</label>
            <input type="file" name="foto" accept=".jpg,.jpeg,.png" required>

            <br><br>
            <button type="submit" class="btn-signin">Upload</button>
            <a href="kelola_galeri.php" class="btn-signup">← Kembali</a>
        </form>
    </div>
</body>
</html>
