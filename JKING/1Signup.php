<?php
session_start();
require_once 'koneksi.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $message = "❌ Username sudah digunakan.";
    } else {
        $insert = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $insert->execute([$username, $password]);
        $message = "✅ Berhasil mendaftar! Silakan login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up - JKING Holdings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .signup-container {
            width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .signup-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .signup-container input[type="text"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .signup-container button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        .signup-container p {
            text-align: center;
            margin-top: 15px;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Buat Akun Baru</h2>

        <?php if ($message): ?>
            <p class="message <?= str_contains($message, '✅') ? 'success' : 'error' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>

        <p>Sudah punya akun? <a href="signin.php">Login di sini</a></p>
    </div>
</body>
</html>
