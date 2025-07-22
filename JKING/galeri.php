<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM galeri");
?>

<h2>Galeri</h2>
<a href="upload.php"> Upload Baru</a>
<table border="1" cellpadding="8">
  <tr>
    <th>No</th><th>Foto</th><th>Keterangan</th><th>Aksi</th>
  </tr>
  <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><img src="uploads/<?= $row['nama_file'] ?>" width="100"></td>
      <td><?= $row['keterangan'] ?></td>
      <td>
        <a href="edit_foto.php?id=<?= $row['id'] ?>"> Edit</a> |
        <a href="hapus_foto.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin?')">🗑️ Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
