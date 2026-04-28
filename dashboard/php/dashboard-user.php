<?php include 'connected.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Katalog Barang</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>


<div class="container">
    <h2>Barang Sewa</h2>

    <div class="grid">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM barang_sewa");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
            <div class="card">
                <img src="../../uploads/<?= $row['gambar']; ?>">
                <h4><?= $row['nama_barang']; ?></h4>
                <p>Rp <?= number_format($row['harga_per_hari']); ?>/Hari</p>

                <?php if ($row['status']) { ?>
                    <span class="status available">Tersedia</span>
                <?php } else { ?>
                    <span class="status borrowed">Dipinjam</span>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>