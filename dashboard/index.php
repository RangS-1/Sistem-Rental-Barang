<?php 
include 'Connected.php'; 
$page = isset($_GET['p']) ? $_GET['p'] : 'home';
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
            <li><a href="dashboard-user.php?p=home" class="<?= $page == 'home' ? 'active' : '' ?>">Home</a></li>
            <li><a href="dashboard-user.php?p=katalog" class="<?= $page == 'katalog' ? 'active' : '' ?>">Barang yang Disewa</a></li>
            <li><a href="dashboard-user.php?p=about" class="<?= $page == 'about' ? 'active' : '' ?>">About</a></li>
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
                $query = mysqli_query($koneksi, "SELECT * FROM barang_sewa WHERE status = 1 LIMIT 3");
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
                                <!-- KODE PENTING: Status Tersedia (Background Hijau) -->
                                <span class="status available">Tersedia</span>
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
                $query = mysqli_query($koneksi, "SELECT * FROM barang_sewa WHERE status = 0 LIMIT 3");
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

    <?php elseif ($page == 'about'): ?>
        <!-- HALAMAN ABOUT -->
        <div class="page-content animate-fade">
            <div class="header-section">
                <h2>Tentang Kami</h2>
                <p>Mengenal lebih dekat layanan SewaBarang.</p>
            </div>
            <div class="about-card">
                <p>SewaBarang adalah platform penyewaan barang terpercaya yang berdiri sejak tahun 2024. Kami berdedikasi untuk memberikan pelayanan terbaik dengan unit yang selalu terawat dan sistem yang transparan.</p>
            </div>
        </div>
    <?php endif; ?>

</div>

</body>
</html>