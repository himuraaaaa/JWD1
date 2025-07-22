<?php
session_start();

// Cek apakah user login sebagai admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php"); // redirect ke login kalau bukan admin
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .admin-container {
      padding: 20px;
    }

    .admin-card {
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      background-color: #f9f9f9;
    }

    .admin-card h3 {
      margin-top: 0;
    }

    .admin-actions a {
      display: inline-block;
      padding: 8px 12px;
      margin: 5px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }

    .admin-actions a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<?php include 'template/header.php'; ?>

<div class="admin-container">
  <h2> Dashboard Admin JKING Holdings</h2>

  <div class="admin-card">
    <h3>Selamat datang </h3>
    <p>Anda login sebagai <strong>Admin</strong>.</p>
  </div>

  <div class="admin-card">
    <h3>Menu Navigasi</h3>
    <div class="admin-actions">
      <a href="uploadartikel.php"> Upload Artikel</a>
      <a href="uploadgaleri.php"> Upload File</a>
      <a href="kelolauser.php"> Kelola Pengguna</a>
      <a href="logout.php"> Logout</a>
    </div>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
  <a href="kelola_galeri.php" class="btn-auth" style="background-color: #007bff;">Kelola File</a>
<?php endif; ?>

</body>
</html>

