<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deskripsi = $_POST['deskripsi'];
    $nama_file = $_FILES['file']['name'];
    $tmp_file  = $_FILES['file']['tmp_name'];

    $target = "../uploads/" . basename($nama_file);

    if (move_uploaded_file($tmp_file, $target)) {
        $koneksi->query("INSERT INTO file_upload (nama_file, deskripsi) VALUES ('$nama_file', '$deskripsi')");
        header("Location: index.php");
    } else {
        echo "Upload gagal!";
    }
}
?>

<h2>Upload File</h2>
<form method="post" enctype="multipart/form-data">
    Pilih File: <input type="file" name="file" required><br><br>
    Deskripsi: <br>
    <textarea name="deskripsi" rows="4" cols="50"></textarea><br><br>
    <input type="submit" value="Upload">
</form>
