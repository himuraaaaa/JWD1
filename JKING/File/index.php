<?php
include '../koneksi.php';
$data = $koneksi->query("SELECT * FROM file_upload ORDER BY tanggal_upload DESC");
?>

<h2>Daftar File Upload</h2>
<a href="tambah.php">Upload File Baru</a><br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama File</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $data->fetch_assoc()): ?>
    <tr>
        <td><a href="../uploads/<?= $row['nama_file'] ?>" target="_blank"><?= $row['nama_file'] ?></a></td>
        <td><?= $row['deskripsi'] ?></td>
        <td><?= $row['tanggal_upload'] ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus file ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
