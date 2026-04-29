<?php
include 'ambil.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard-user.php");
    exit;
}

require_once 'class/Controll.php';

$pengontroll = new Control();
$pengontroll->handleRequest();

$data = $pengontroll->index();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/db-admin.css">
</head>
<body>

<div class="container">

    <h2 class="title">Dashboard Admin</h2>

    <div class="card form-card">
        <h3>Tambah Barang</h3>
        <form method="POST" enctype="multipart/form-data" class="form">
            <input type="text" name="nama_barang" placeholder="Nama Barang" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <textarea name="deskripsi"></textarea>
            <input type="file" name="gambar" required>
            <button name="tambah_barang" class="btn primary">Tambah</button>
        </form>
    </div>

    <div class="card form-card">
        <h3>Tambah Admin</h3>
        <form method="POST" class="form">
            <input type="text" name="name" placeholder="Nama">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button name="tambah_admin" class="btn primary">Tambah Admin</button>
        </form>
    </div>

    <div class="card">
        <h3>Data Barang</h3>

        <table class="table">
            <tr>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($koneksi)) { ?>
            <tr>
                <td><?= $row['nama_barang']; ?></td>
                <td>
                    <span class="badge <?= $row['status'] ? 'available' : 'borrowed'; ?>">
                        <?= $row['status'] ? 'Tersedia' : 'Dipinjam'; ?>
                    </span>
                </td>
                <td>
                    <a href="?toggle_status=<?= $row['id']; ?>" class="btn small warning">Toggle</a>
                    <a href="?hapus=<?= $row['id']; ?>" class="btn small danger">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
