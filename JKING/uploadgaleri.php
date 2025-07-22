<?php
include 'Koneksi.php'; // Pastikan Koneksi.php ini sudah menyediakan $pdo object
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = $_POST['id'];
    $judul       = $_POST['judul'];       // Tidak perlu mysqli_real_escape_string lagi
    $keterangan  = $_POST['keterangan'];  // Tidak perlu mysqli_real_escape_string lagi
    $isi         = $_POST['isi'];         // Tidak perlu mysqli_real_escape_string lagi
    $kategori    = $_POST['kategori'];    // Tidak perlu mysqli_real_escape_string lagi
    $foto_lama   = $_POST['foto_lama'];
    $nama_file   = $foto_lama; // Default menggunakan nama file lama

    $pesan = ""; // Inisialisasi pesan untuk respons ke user jika perlu

    // Proses upload foto baru jika ada
    if (!empty($_FILES['foto']['name'])) {
        $fileName = $_FILES['foto']['name'];
        $tmpName  = $_FILES['foto']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed)) {
            $folder = "uploads/";
            // Pastikan folder 'uploads/' ada. Jika tidak, buat.
            // Anda perlu memastikan folder ini memiliki izin tulis di server.
            if (!is_dir($folder)) {
                if (!mkdir($folder, 0777, true)) { // Buat folder dengan izin 0777 rekursif
                    die("Gagal membuat folder upload. Mohon periksa izin.");
                }
            }
            
            $nama_file = uniqid() . "." . $fileExt; // Buat nama file unik

            if (move_uploaded_file($tmpName, $folder . $nama_file)) {
                // Hapus foto lama dari folder (jika ada dan baru)
                if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
                    unlink($folder . $foto_lama);
                }
            } else {
                $pesan = "❌ Gagal mengupload foto baru.";
                // Jika upload foto gagal, gunakan nama file lama agar tidak kehilangan foto
                $nama_file = $foto_lama; 
            }
        } else {
            $pesan = "❗ Format file tidak diizinkan. Hanya JPG, JPEG, PNG.";
            // Jika format tidak diizinkan, gunakan nama file lama
            $nama_file = $foto_lama; 
        }
    }

    // Menggunakan Prepared Statement PDO untuk UPDATE
    $sql = "UPDATE galeri SET 
                judul = ?, 
                keterangan = ?, 
                isi = ?, 
                nama_file = ?, 
                kategori = ? 
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    
    // Eksekusi statement dengan binding parameter
    if ($stmt->execute([$judul, $keterangan, $isi, $nama_file, $kategori, $id])) {
        // Hanya redirect jika tidak ada pesan error dari proses upload foto
        if (empty($pesan)) {
            header("Location: foto-klien.php?edit=success");
            exit;
        } else {
            // Jika ada pesan dari proses upload foto, tampilkan pesan tersebut
            echo "<p style='color:orange;'>⚠️ Data berhasil diupdate, tetapi ada masalah dengan foto: " . $pesan . "</p>";
        }
    } else {
        // Mengambil informasi error dari PDO
        $errorInfo = $stmt->errorInfo();
        echo "<p style='color:red;'>❌ Gagal update data: " . $errorInfo[2] . "</p>";
    }
} else {
    echo "<p style='color:red;'>Permintaan tidak valid.</p>";
}
?>