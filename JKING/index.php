<?php 
session_start();
include 'template/header.php'; 
?>
<div class="main-wrapper">
    <aside class="sidebar">
        <h3>Artikel</h3>
<select onchange="location = this.value;">
  <option disabled selected>Pilih Artikel</option>
  <option value="artikel1.php">Inovasi Teknologi Konstruksi</option>
  <option value="artikel2.php">Strategi Green Building</option>
  <option value="artikel3.php">Manajemen Risiko Proyek</option>
</select>
<h2>Event Galery</h2>
<a href="event.php">Event Perusahaan</a><br>
<a href="foto-klien.php">Galery Klien</a>
        <?php if (isset($_SESSION['user'])): ?>
            <p><strong><?= $_SESSION['user'] ?></strong>
            (<?= isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'Admin' : 'Pengunjung' ?>)</p>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php" class="btn-auth btn-signin">Kelola Konten</a><br>
            <?php endif; ?>

            <a href="logout.php" class="btn-auth btn-signup">Logout</a>
        <?php else: ?>
            <a href="signin.php" class="btn-auth btn-signin">Sign In</a><br>
            <a href="signup.php" class="btn-auth btn-signup">Sign Up</a>
        <?php endif; ?>
    </aside>

    <main class="content">
        <h2>Selamat Datang di JKING Holdings</h2>
        <p>Perusahaan konstruksi terkemuka sejak 1992.</p>
        <p>Mewujudkan bangunan impian Anda dengan teknologi terbaik dan tim profesional.</p>
    </main>
</div>
<?php include 'template/footer.php'; ?>
