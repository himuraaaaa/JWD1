<?php
session_start();

// Hanya admin yang boleh mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

// Koneksi database
include 'Koneksi.php';

$pesan = "";

// Hapus user jika diminta
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $hapus = mysqli_query($conn, "DELETE FROM users WHERE id = $id");

    if ($hapus) {
        $pesan = "✅ Pengguna berhasil dihapus.";
    } else {
        $pesan = "❌ Gagal menghapus pengguna.";
    }
}

// Ambil data semua pengguna
$users = mysqli_query($conn, "SELECT id, username, role FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .table-container {
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    table th {
      background-color: #f0f0f0;
    }
    .btn-hapus {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 3px;
      text-decoration: none;
    }
    .btn-kembali {
      display: inline-block;
      margin-top: 15px;
      background-color: #6c757d;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<?php include 'template/header.php'; ?>

<div class="table-container">
  <h2>Daftar Pengguna</h2>

  <?php if ($pesan): ?>
    <p><?php echo $pesan; ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($user = mysqli_fetch_assoc($users)) : ?>
        <tr>
          <td><?php echo $user['id']; ?></td>
          <td><?php echo $user['username']; ?></td>
          <td><?php echo $user['role']; ?></td>
          <td>
            <?php if ($user['role'] !== 'admin') : ?>
              <a class="btn-hapus" href="?hapus=<?php echo $user['id']; ?>" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
            <?php else: ?>
              <span style="color:gray;">(Admin)</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="admin.php" class="btn-kembali">← Kembali ke Dashboard</a>
</div>

</body>
</html>
