<?php
session_start();
include 'ambil.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Naik satu tingkat folder ke index utama
    exit;
}

require_once 'class/Control.php';
$adminControl = new Control();
$adminControl->handleRequest();

$queryBarang = mysqli_query($conn, "SELECT * FROM barang_sewa ORDER BY id DESC");
$totalItem   = mysqli_num_rows($queryBarang);
$tersedia    = 0;
$disewa      = 0;
$listBarang  = [];

while ($row = mysqli_fetch_assoc($queryBarang)) {
    $listBarang[] = $row;
    ($row['status'] == 1) ? $tersedia++ : $disewa++;
}

// Hitung persentase ketersediaan untuk widget
$persenReady = ($totalItem > 0) ? round(($tersedia / $totalItem) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RentalIn</title>
    
    <!-- Memanggil CSS Eksternal -->
    <link rel="stylesheet" href="../assets/css/db-admin.css">
    
    <!-- Library Grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- NAVBAR UTAMA -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Rental<span>In</span></a>
            <ul class="nav-menu">
                <li><a href="#statistik">Statistik</a></li>
                <li><a href="#tambah-barang">Manajemen</a></li>
                <li><a href="#data-barang">Inventaris</a></li>
                <li><a href="logout.php" class="btn-logout">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        
        <!-- BAGIAN 1: STATISTIK & GRAFIK -->
        <section id="statistik">
            <h2 class="section-title">Ringkasan Performa</h2>
            <div class="stats-grid">
                <div class="card card-stat-green">
                    <p>Ketersediaan Barang</p>
                    <div class="stat-value stat-green"><?= $persenReady; ?>%</div>
                    <small><?= $tersedia; ?> Unit Siap Sewa</small>
                </div>
                <div class="card card-stat-blue">
                    <p>Total Koleksi</p>
                    <div class="stat-value stat-blue"><?= $totalItem; ?></div>
                    <small>Item dalam Database</small>
                </div>
            </div>
            
            <div class="card">
                <div class="chart-container" style="position: relative; height:300px;">
                    <canvas id="rentalinChart"></canvas>
                </div>
            </div>
        </section>

        <!-- BAGIAN 2: FORM INPUT BARANG -->
        <section id="tambah-barang">
            <div class="card">
                <h3>📦 Registrasi Item Baru</h3>
                <form method="POST" enctype="multipart/form-data" class="form-group">
                    <input type="text" name="nama_barang" placeholder="Nama Barang" required class="input-field">
                    <input type="number" name="harga" placeholder="Harga Sewa (Rp)" required class="input-field">
                    <textarea name="deskripsi" placeholder="Spesifikasi atau Deskripsi singkat..." class="input-field"></textarea>
                    
                    <div class="upload-wrapper">
                        <label>Foto Produk:</label>
                        <input type="file" name="gambar" required class="input-file">
                    </div>
                    
                    <button name="tambah_barang" class="btn-submit">Simpan ke Database</button>
                </form>
            </div>
        </section>

        <!-- BAGIAN 3: TABEL DATA -->
        <section id="data-barang">
            <div class="card">
                <h3>📊 Tabel Inventaris Barang</h3>
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Aksi Navigasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($listBarang)): ?>
                                <tr>
                                    <td colspan="3" style="text-align:center;">Belum ada data barang.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($listBarang as $item) : ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($item['nama_barang']); ?></strong></td>
                                    <td>
                                        <span class="badge <?= ($item['status'] == 1) ? 'available' : 'borrowed'; ?>">
                                            <?= ($item['status'] == 1) ? 'Tersedia' : 'Disewa'; ?>
                                        </span>
                                    </td>
                                    <td class="action-cell">
                                        <a href="?toggle_status=<?= $item['id']; ?>" class="btn-action btn-warning">Ubah Status</a>
                                        <a href="?hapus=<?= $item['id']; ?>" 
                                           onclick="return confirm('Hapus item ini secara permanen?')" 
                                           class="btn-action btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

    <!-- SCRIPT GRAFIK CUSTOM -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('rentalinChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Siap Sewa (Ready)', 'Sedang Disewa'],
                    datasets: [{
                        label: 'Jumlah Unit',
                        data: [<?= $tersedia; ?>, <?= $disewa; ?>],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)', // Green
                            'rgba(239, 68, 68, 0.8)'   // Red
                        ],
                        borderColor: ['#22c55e', '#ef4444'],
                        borderWidth: 2,
                        borderRadius: 8,
                        barThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>