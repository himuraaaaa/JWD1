<?php
session_start();
include 'Koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit;
}

// Cek apakah ID ada di URL
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM galeri WHERE id = $id");

// Cek apakah data ditemukan
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Galeri Klien</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit Galeri Klien</h2>
    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label>Nama:</label>
        <input type="text" name="nama_file" value="<?= $row['nama_file'] ?>" required>

        <label>Deskripsi:</label>
        <textarea name="keterangan" rows="3" required><?= $row['keterangan'] ?></textarea>

        <label>Tanggal Upload:</label>
        <input type="text" name="tanggal_upload" value="<?= $row['tanggal_upload'] ?>" required>

        <label>Kategori:</label>
        <select name="kategori" required>
        <option value="umum" <?= $row['kategori'] == 'umum' ? 'selected' : '' ?>>Umum</option>
        <option value="klien" <?= $row['kategori'] == 'klien' ? 'selected' : '' ?>>Klien</option>
        </select>


        <label>Ganti Foto (opsional):</label><br>
        <img src="uploads/<?= $row['nama_file'] ?>" width="150"><br><br>
        <input type="file" name="foto_baru"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
