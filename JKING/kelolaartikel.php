<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}
include 'Koneksi.php';
$artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>
<?php
include 'Koneksi.php';
$artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal DESC");
?>
<?php while ($row = mysqli_fetch_assoc($artikel)) : ?>
  <tr>
    <td><?= htmlspecialchars($row['judul']) ?></td>
    <td><?= substr(htmlspecialchars($row['isi']), 0, 100) ?>...</td>
    <td>
      <a href="hapus_artikel.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau hapus?')">🗑 Hapus</a>
    </td>
  </tr>
<?php endwhile; ?>

<h2>Daftar Artikel</h2>
<table border="1" cellpadding="10">
  <tr>
    <th>Judul</th>
    <th>Isi</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($artikel)) : ?>
    <tr>
      <td><?= htmlspecialchars($row['judul']) ?></td>
      <td><?= substr(htmlspecialchars($row['isi']), 0, 100) ?>...</td>
      <td>
        <a href="hapus_artikel.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
