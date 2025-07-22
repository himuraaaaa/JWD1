<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("❌ Akses ditolak");
}
?>

<div style="background-color:#eee; padding:10px 20px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #ccc; font-family:Arial">
  <div>
    <strong>Admin (<?= $_SESSION['username'] ?>)</strong>
  </div>
  <div>
    <a href="kelola_user.php">Kelola Pengguna</a> |
    <a href="uploadartikel.php">Kelola Artikel</a> |
    <a href="kelola_galeri.php">Kelola Galeri</a> |
    <a href="logout.php">Logout</a>
  </div>
</div>
