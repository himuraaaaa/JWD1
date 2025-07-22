<?php
session_start();

// Hanya admin yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

// Koneksi database
include 'Koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);

    if (!empty($judul) && !empty($isi)) {
        $query = "INSERT INTO artikel (judul, isi) VALUES ('$judul', '$isi')";
        if (mysqli_query($conn, $query)) {
            $pesan = "✅ Artikel berhasil diupload!";
        } else {
            $pesan = "❌ Gagal upload: " . mysqli_error($conn);
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

<?php include 'Template/header.php'; ?>

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
