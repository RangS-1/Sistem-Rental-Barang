<?php 
include 'ambil.php'; 
$page = isset($_GET['p']) ? $_GET['p'] : 'home';
session_start();

// Jika bukan user, masuk ke dashboard admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: dashboard-admin.php");
    exit;
}
$db = new Connected();
$conn = $db->getConnection();

?>

<!DOCTYPE html>
<html>
<head>
    <title>SewaBarang - Sistem Rental</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<!-- Tampilan DashBoard USER!!!-->
<nav class="main-navbar">
    <div class="nav-container">
        <ul class="nav-links">
            <li><a href="index.php?p=home" class="<?= $page == 'home' ? 'active' : '' ?>">Home</a></li>
            <li><a href="index.php?p=katalog" class="<?= $page == 'katalog' ? 'active' : '' ?>">Barang yang Disewa</a></li>
            <li><a href="index.php?p=logout" class="<?= $page == 'logout' ? 'active' : '' ?>">Logout</a></li>
            <li><a href="index.php?p=about" class="<?= $page == 'about' ? 'active' : '' ?>">About</a></li>
        </ul>
    </div>
</nav>

<div class="container">

    <?php if ($page == 'home'): ?>
        <div class="page-content animate-fade">
            <div class="header-section">
                <h2>Barang Tersedia untuk Anda</h2>
                <p>Silakan pilih barang yang siap untuk dipinjam hari ini.</p>
            </div>

            <div class="grid">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM barang_sewa WHERE status = 1");
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <div class="card">
                        <div class="card-img-wrapper">
                            <img src="uploads/<?= $row['gambar']; ?>" alt="<?= $row['nama_barang']; ?>">
                        </div>
                        <div class="card-body">
                            <h4><?= $row['nama_barang']; ?></h4>
                            <p class="price">Rp <?= number_format($row['harga_per_hari']); ?> <span>/ Hari</span></p>

                            <div class="status-wrapper">
                                <form action="class/Penyewaan.php" method="GET" onsubmit="return confirm('Apakah Anda yakin ingin meminjam <?= $row['nama_barang']; ?>?')">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="pinjam">
                                        <i class="Text-pinjam"></i> Pinjam Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php elseif ($page == 'katalog'): ?>
        <div class="page-content animate-fade">
            <div class="header-section">
                <h2>Sedang Dipinjamkan</h2>
                <p>Daftar barang yang saat ini sedang digunakan oleh pelanggan lain.</p>
            </div>

            <div class="grid">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM barang_sewa WHERE status = 0");
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <div class="card">
                        <div class="card-img-wrapper">
                            <img src="../../uploads/<?= $row['gambar']; ?>">
                        </div>
                        <div class="card-body">
                            <h4><?= $row['nama_barang']; ?></h4>
                            <p class="price">Rp <?= number_format($row['harga_per_hari']); ?> <span>/ Hari</span></p>

                            <div class="status-wrapper">
                                <!-- KODE PENTING: Status Dipinjam (Background Oren) -->
                                <span class="status borrowed">Sedang Dipinjam</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php elseif ($page == 'logout'): ?>
        <div class="card-body">
            <a href="logout.php" class="logout">Logout</a>
        </div>
    <?php elseif ($page == 'about'): ?>
        <!-- HALAMAN ABOUT -->
        <div class="page-content animate-fade">
    <div class="header-section">
        <h2>Tentang Kami</h2>
        <p>Proyek ini dikerjakan oleh Tim 7 SMK Wikrama 1 Garut.</p>
    </div>
    
    <!-- Menambahkan class 'team-card' untuk spesifikasi styling -->
    <div class="card team-card">
        <div class="card-img-wrapper">
            <img src="uploads/team.jpg" alt="Tim 7 SMK Wikrama 1 Garut">
        </div>
        <div class="card-body">
            <p>
                Kami telah bekerja sama semaksimal mungkin untuk menyelesaikan proyek ini.
                Anggota tim terdiri dari:
            </p>
            <br>
            <ul style="list-style-type: none; margin-left: 20px; text-align: left;">
                <li>Rangga Wijaya (RangS): Tech Lead, Bug Tester, Backend Developer</li>
                <li>Alfi Alfatih (Denziqbal): Frontend Developer, UI/UX dashboard user, Register and Login</li>
                <li>Rayhan Aidil (Clark): Frontend Developer, UI/UX dashboard admin</li>
                <li>Arbiansyah (Arbian): Documentation, CSS Helper</li>
            </ul>
        </div>
    </div>
</div>
    <?php endif; ?>

</div>

</body>
</html>