<?php include 'template/header.php'; ?>

<div class="admin-container">
  <h2>Kelola Galeri Klien</h2>
  <a href="uploadgaleri.php" class="btn-primary">Tambah foto</a>

  <table class="table-galeri">
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Foto</th>
        <th>Keterangan</th>
        <th>Isi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include 'Koneksi.php';
      $result = mysqli_query($conn, "SELECT * FROM galeri WHERE kategori='klien' ORDER BY id DESC");
      $no = 1;
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['judul']}</td>
                <td><img src='uploads/{$row['nama_file']}' width='100'></td>
                <td>{$row['keterangan']}</td>
                <td>{$row['isi']}</td>
                <td>
                  <a href='editgaleri.php?id={$row['id']}'>Edit</a> |
                  <a href='hapusfoto.php?id={$row['id']}' onclick=\"return confirm('Hapus foto ini?');\" style='color:red;'>🗑 Hapus</a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>
