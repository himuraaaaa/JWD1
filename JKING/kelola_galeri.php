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
      // Pastikan Koneksi.php ini sudah menyediakan $pdo object
      include 'Koneksi.php';

      // Menggunakan PDO untuk SELECT query
      $stmt = $pdo->query("SELECT * FROM galeri WHERE kategori='klien' ORDER BY id DESC");
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ambil semua hasil sekaligus

      $no = 1;
      foreach ($rows as $row) { // Menggunakan foreach untuk mengiterasi hasil PDO
        echo "<tr>
                <td>{$no}</td>
                <td>" . htmlspecialchars($row['judul']) . "</td>
                <td><img src='uploads/" . htmlspecialchars($row['nama_file']) . "' width='100'></td>
                <td>" . htmlspecialchars($row['keterangan']) . "</td>
                <td>" . htmlspecialchars($row['isi']) . "</td>
                <td>
                  <a href='editgaleri.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> |
                  <a href='hapusfoto.php?id=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Hapus foto ini?');\" style='color:red;'>🗑 Hapus</a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>