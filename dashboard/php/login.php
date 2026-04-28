<?php
session_start();
include "connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

// cek apakah username ada
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");

if (mysqli_num_rows($query) == 0) {
    echo "Username tidak terdaftar!";
    exit;
}

$data = mysqli_fetch_assoc($query);

// verifikasi password
if (password_verify($password, $data['password'])) {

    // simpan data ke session
    $_SESSION['login']    = true;
    $_SESSION['id_user']  = $data['id'];      // sesuaikan dengan field ID
    $_SESSION['name']     = $data['name'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['email']    = $data['email'];

    header("Location: dashboard.php");
    exit;

} else {
    echo "Hayolo salah!";
}
?>