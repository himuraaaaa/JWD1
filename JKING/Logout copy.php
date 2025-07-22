<?php
session_start();
session_destroy(); // hapus semua data session (user, role, dll)
header("Location: index.php"); // kembali ke beranda
exit();
?>
