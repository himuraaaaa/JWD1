<?php
session_start();
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
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

$id = intval($_GET['id']); // Pastikan ID adalah integer

// Menggunakan Prepared Statement PDO untuk SELECT
$sql = "SELECT * FROM galeri WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]); // Eksekusi dengan binding parameter ID

// Cek apakah data ditemukan
if ($stmt->rowCount() == 0) { // Menggunakan rowCount() untuk memeriksa jumlah baris
    echo "Data tidak ditemukan.";
    exit;
}

$row = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil satu baris hasil sebagai array asosiatif
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
    <form action="updategaleri.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($row['nama_file']) ?>"> <label>Judul:</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" required>

        <label>Keterangan:</label>
        <textarea name="keterangan" rows="3" required><?= htmlspecialchars($row['keterangan']) ?></textarea>

        <label>Isi:</label>
        <textarea name="isi" rows="6" required><?= htmlspecialchars($row['isi']) ?></textarea>

        <label>Kategori:</label>
        <select name="kategori" required>
            <option value="umum" <?= ($row['kategori'] == 'umum') ? 'selected' : '' ?>>Umum</option>
            <option value="klien" <?= ($row['kategori'] == 'klien') ? 'selected' : '' ?>>Klien</option>
        </select>

        <label>Ganti Foto (opsional):</label><br>
        <img src="uploads/<?= htmlspecialchars($row['nama_file']) ?>" width="150" alt="Foto Lama"><br><br>
        <input type="file" name="foto"><br><br> <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>