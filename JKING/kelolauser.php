<?php
session_start();

// Hanya admin yang boleh mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

// Koneksi database
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
include 'Koneksi.php';

$pesan = "";

// Hapus user jika diminta
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // Pastikan ID adalah integer

    // Menggunakan Prepared Statement PDO untuk DELETE
    $stmt_delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
    
    // Eksekusi statement
    if ($stmt_delete->execute([$id])) {
        $pesan = "✅ Pengguna berhasil dihapus.";
    } else {
        // Mengambil informasi error dari PDO
        $errorInfo = $stmt_delete->errorInfo();
        $pesan = "❌ Gagal menghapus pengguna: " . $errorInfo[2];
    }
}

// Ambil data semua pengguna
// Menggunakan PDO untuk SELECT
// Pastikan baris 28 di sini yang diubah
$stmt_users = $pdo->query("SELECT id, username, role FROM users");
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC); // Ambil semua baris sekaligus
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* ... (CSS Anda tetap sama) ... */
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
      <?php foreach ($users as $user) : // Menggunakan foreach untuk mengiterasi hasil PDO ?>
        <tr>
          <td><?php echo htmlspecialchars($user['id']); ?></td>
          <td><?php echo htmlspecialchars($user['username']); ?></td>
          <td><?php echo htmlspecialchars($user['role']); ?></td>
          <td>
            <?php if ($user['role'] !== 'admin') : ?>
              <a class="btn-hapus" href="?hapus=<?php echo htmlspecialchars($user['id']); ?>" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
            <?php else: ?>
              <span style="color:gray;">(Admin)</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; // Penutup foreach ?>
    </tbody>
  </table>

  <a href="admin.php" class="btn-kembali">← Kembali ke Dashboard</a>
</div>

</body>
</html>