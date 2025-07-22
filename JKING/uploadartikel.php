<?php
session_start();

// Hanya admin yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

// Koneksi database
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
include 'Koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul']; // Tidak perlu mysqli_real_escape_string lagi
    $isi   = $_POST['isi'];   // Tidak perlu mysqli_real_escape_string lagi

    if (!empty($judul) && !empty($isi)) {
        // Menggunakan Prepared Statement PDO untuk INSERT
        $stmt = $pdo->prepare("INSERT INTO artikel (judul, isi) VALUES (?, ?)");
        
        // Eksekusi statement dengan binding parameter
        if ($stmt->execute([$judul, $isi])) {
            $pesan = "✅ Artikel berhasil diupload!";
        } else {
            // Mengambil informasi error dari PDO
            $errorInfo = $stmt->errorInfo();
            $pesan = "❌ Gagal upload: " . $errorInfo[2]; // $errorInfo[2] berisi pesan error SQL
        }
    } else {
        $pesan = "❗ Judul dan Isi tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Artikel</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* ... (CSS Anda tetap sama) ... */
    .form-container {
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      background: #fefefe;
      border-radius: 10px;
    }
    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 15px;
      border: 1px solid #aaa;
      border-radius: 5px;
    }
    button {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .message {
      margin-top: 15px;
      color: green;
    }
    .btn-kembali {
      margin-top: 20px;
      display: inline-block;
      background-color: #6c757d;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn-kembali:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>

<?php include 'template/header.php'; ?>

<div class="form-container">
  <h2>Upload Artikel</h2>

  <?php if (!empty($pesan)) : ?>
    <p class="message"><?php echo $pesan; ?></p>
  <?php endif; ?>

  <form method="POST">
    <label for="judul">Judul Artikel:</label><br>
    <input type="text" name="judul" id="judul" required><br>

    <label for="isi">Isi Artikel:</label><br>
    <textarea name="isi" id="isi" rows="6" required></textarea><br>

    <button type="submit">Upload</button>
  </form>

  <a href="admin.php" class="btn-kembali">← Kembali ke Dashboard</a>
</div>

</body>
</html>