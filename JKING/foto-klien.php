<?php
include 'template/header.php';
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
include 'Koneksi.php';
?>
<h2 style="text-align: center; margin-top: 30px;">Galeri Foto Klien</h2>
<div style="
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    padding: 30px;
">
<?php
// PERUBAHAN UTAMA DIMULAI DI SINI
// Menggunakan PDO untuk query
$stmt = $pdo->query("SELECT * FROM galeri WHERE kategori='klien' ORDER BY id DESC");
// Mengambil semua hasil sekaligus
$galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($galleries as $row) {
?>
    <div style="
        width: 250px;
        border: 1px solid #ddd;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #fff;
        text-align: left;
        transition: transform 0.2s ease;
    ">
        <img src="uploads/<?= htmlspecialchars($row['nama_file']) ?>" alt="Foto" style="width: 100%; height: 180px; object-fit: cover;">
        <div style="padding: 15px;">
            <h4 style="margin: 0 0 10px 0; font-size: 16px; color: #333;"><?= htmlspecialchars($row['judul']) ?></h4>
            <p style="font-size: 14px; color: #666;"><?= htmlspecialchars($row['isi']) ?></p>
        </div>
    </div>
<?php } // Penutup foreach ?>
</div>