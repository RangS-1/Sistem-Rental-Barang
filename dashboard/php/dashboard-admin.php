<?php
include '../../config.php';

if (isset($_POST['tambah_barang'])) {

    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../../uploads/" . $gambar);

    mysqli_query($conn, "INSERT INTO barang_sewa 
        (nama_barang, deskripsi, harga_per_hari, gambar, status) 
        VALUES ('$nama','$deskripsi','$harga','$gambar', TRUE)");
}

// Hapus barang!
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM barang_sewa WHERE id=$id");
}

// Status barang!
if (isset($_GET['toggle_status'])) {
    $id = $_GET['toggle_status'];

    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT status FROM barang_sewa WHERE id=$id"));

    $newStatus = $data['status'] ? 0 : 1;

    mysqli_query($conn, "UPDATE barang_sewa SET status=$newStatus WHERE id=$id");
}

// Tambah admin baru!
if (isset($_POST['tambah_admin'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users (name, email, password, role) 
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
    <title>Dashboard Admin RentalIn</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
    <input type="text" name="nama_barang" placeholder="Nama Barang" required>
    <input type="number" name="harga" placeholder="Harga per hari" required>
    <textarea name="deskripsi"></textarea>
    <input type="file" name="gambar" required>
    <button name="tambah_barang">Tambah</button>
</form>

<form method="POST">
    <input type="text" name="name" placeholder="Nama">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button name="tambah_admin">Tambah Admin</button>
</form>
<?php
$data = mysqli_query($koneksi, "SELECT * FROM barang_sewa");

while ($row = mysqli_fetch_assoc($data)) {
?>
    <div>
        <?= $row['nama_barang']; ?> |
        Status: <?= $row['status'] ? 'Tersedia' : 'Dipinjam'; ?>

        <a href="?toggle_status=<?= $row['id']; ?>">Toggle Status</a>
        <a href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </div>
<?php } ?>
</body>
</html>
