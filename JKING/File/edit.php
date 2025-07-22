<?php
include '../koneksi.php';
$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM file_upload WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deskripsi = $_POST['deskripsi'];
    $koneksi->query("UPDATE file_upload SET deskripsi='$deskripsi' WHERE id=$id");
    header("Location: index.php");
}
?>

<h2>Edit Deskripsi File</h2>
<form method="post">
    File: <strong><?= $data['nama_file'] ?></strong><br><br>
    Deskripsi:<br>
    <textarea name="deskripsi" rows="4" cols="50"><?= $data['deskripsi'] ?></textarea><br><br>
    <input type="submit" value="Update">
</form>
