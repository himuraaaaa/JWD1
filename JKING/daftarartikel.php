<?php
include 'Koneksi.php';

</form>

<br>
<a href="admin.php" style="text-decoration:none;">
  <button style="background-color:#6c757d; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer;">
    ← Kembali ke Dashboard
  </button>
</a>

$query = "SELECT * FROM artikel ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content">
  <h2>📚 Artikel Terbaru</h2>

  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="artikel">
      <h3><?= htmlspecialchars($row['judul']) ?></h3>
      <small><i><?= $row['tanggal'] ?></i></small>
      <p><?= nl2br(htmlspecialchars(substr($row['isi'], 0, 200))) ?>...</p>
    </div>
  <?php endwhile; ?>
</div>
