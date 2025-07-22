<?php
session_start();
// Pastikan Koneksi.php ini sudah menyediakan $pdo object
include 'Koneksi.php';

// Hanya admin yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

$pesan_html = ""; // Variabel untuk menyimpan pesan HTML yang akan ditampilkan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul      = $_POST['judul'];       // Tidak perlu mysqli_real_escape_string lagi
    $keterangan = $_POST['keterangan'];  // Tidak perlu mysqli_real_escape_string lagi
    $isi        = $_POST['isi'];         // Tidak perlu mysqli_real_escape_string lagi
    $kategori   = 'klien';               // Kategori sudah ditetapkan

    $nama_file_baru = null; // Inisialisasi nama file baru

    // Periksa apakah ada file foto yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['foto']['name'];
        $tmpName  = $_FILES['foto']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed)) {
            $folder = "uploads/";
            // Pastikan folder 'uploads/' ada. Buat jika belum.
            // Anda perlu memastikan folder ini memiliki izin tulis di server (0777).
            if (!is_dir($folder)) {
                // mkdir akan mengembalikan false jika gagal, misalnya karena izin
                if (!mkdir($folder, 0777, true)) { 
                    $pesan_html = "<p style='color:red;'>❌ Gagal membuat folder upload. Mohon periksa izin server.</p>";
                    // Hentikan proses lebih lanjut jika folder tidak bisa dibuat
                }
            }
            
            // Lanjutkan jika folder berhasil dibuat atau sudah ada
            if (empty($pesan_html)) {
                $nama_file_baru = uniqid() . "." . $fileExt; // Buat nama file unik
                if (!move_uploaded_file($tmpName, $folder . $nama_file_baru)) {
                    $pesan_html = "<p style='color:red;'>❌ Gagal memindahkan file yang diupload!</p>";
                    $nama_file_baru = null; // Set null jika gagal move
                }
            }
        } else {
            $pesan_html = "<p style='color:red;'>❌ Format file tidak didukung! Hanya JPG, JPEG, PNG.</p>";
        }
    } else if ($_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Ini menangani error upload lainnya selain "tidak ada file"
        $pesan_html = "<p style='color:red;'>❌ Error upload file: " . $_FILES['foto']['error'] . "</p>";
    } else {
        $pesan_html = "<p style='color:red;'>❌ Foto belum dipilih!</p>";
    }

    // Hanya lakukan INSERT ke database jika tidak ada error fatal pada upload file
    if (empty($pesan_html) && !empty($judul) && !empty($isi) && $nama_file_baru !== null) {
        // Menggunakan Prepared Statement PDO untuk INSERT
        $sql = "INSERT INTO galeri (judul, nama_file, keterangan, isi, kategori)
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Eksekusi statement dengan binding parameter
        if ($stmt->execute([$judul, $nama_file_baru, $keterangan, $isi, $kategori])) {
            $pesan_html = "<p style='color:green;'>✅ Foto berhasil diupload dan disimpan ke database!</p>";
        } else {
            // Mengambil informasi error dari PDO
            $errorInfo = $stmt->errorInfo();
            $pesan_html = "<p style='color:red;'>❌ Gagal simpan ke database: " . $errorInfo[2] . "</p>";
            // Jika gagal simpan ke DB, hapus file yang sudah terupload (optional)
            if (file_exists($folder . $nama_file_baru)) {
                unlink($folder . $nama_file_baru);
            }
        }
    } else if (empty($judul) || empty($isi)) {
         $pesan_html = "<p style='color:red;'>❗ Judul dan Isi tidak boleh kosong!</p>";
    }

} // Penutup if ($_SERVER['REQUEST_METHOD'] === 'POST')
else {
    // Jika diakses dengan GET, tampilkan form kosong, tidak perlu pesan "Permintaan tidak valid."
    // Anda bisa menambahkan pesan di sini jika memang ingin menandai bahwa ini bukan hasil POST
    // $pesan_html = "<p style='color:red;'>Permintaan tidak valid.</p>"; // Jika tetap ingin muncul
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Galeri Klien</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ... (CSS Anda dari kode sebelumnya) ... */
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #fefefe;
            border-radius: 10px;
        }
        input[type="text"], textarea, select, input[type="file"] {
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
            /* Warna pesan akan diatur di PHP, bukan di sini */
        }
        .btn-signin { /* Menggunakan nama yang lebih generik */
          background: #007bff;
          color: white;
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        }
        .btn-signup { /* Menggunakan nama yang lebih generik */
          background: #6c757d; /* Warna abu-abu untuk kembali */
          color: white;
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          text-decoration: none; /* Untuk link */
          margin-left: 10px; /* Jarak dari tombol upload */
          display: inline-block;
          line-height: normal; /* Untuk menyamakan tinggi dengan button */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Upload Galeri Klien</h2>
        <?= $pesan_html ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Judul:</label>
            <input type="text" name="judul" required>

            <label>Keterangan:</label>
            <input type="text" name="keterangan" required>

            <label>Isi:</label>
            <textarea name="isi" rows="5" required></textarea>

            <label>Upload Foto:</label>
            <input type="file" name="foto" accept=".jpg,.jpeg,.png" required>

            <br><br>
            <button type="submit" class="btn-signin">Upload</button>
            <a href="kelola_galeri.php" class="btn-signup">← Kembali</a>
        </form>
    </div>
</body>
</html>