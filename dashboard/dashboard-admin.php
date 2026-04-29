<?php
include 'connected.php';

if (isset($_POST['tambah_barang'])) {

    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/" . $gambar);

    mysqli_query($koneksi, "INSERT INTO barang_sewa 
        (nama_barang, deskripsi, harga_per_hari, gambar, status) 
        VALUES ('$nama','$deskripsi','$harga','$gambar', TRUE)");
}

// Hapus barang!
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM barang_sewa WHERE id=$id");
}

// Status barang!
if (isset($_GET['toggle_status'])) {
    $id = $_GET['toggle_status'];

    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT status FROM barang_sewa WHERE id=$id"));

    $newStatus = $data['status'] ? 0 : 1;

    mysqli_query($koneksi, "UPDATE barang_sewa SET status=$newStatus WHERE id=$id");
}

// Tambah admin baru!
if (isset($_POST['tambah_admin'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO users (username, email, password, role) 
                         VALUES ('$name','$email','$password','admin')");
}
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard-user.php");
    exit;
}
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
            <input type="number" name="harga" placeholder="Harga per hari" required>
            <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
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
