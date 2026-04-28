<?php
include "connect.php";

$first_name     = $_POST['first_name'];
$last_name      = $_POST['last_name'];
$email          = $_POST['email'];
$username       = $_POST['username'];
$password       = $_POST['password'];
$con_password   = $_POST['con_password'];

// validasi password
if ($password !== $con_password) {
    echo "Password dan konfirmasi tidak sama!";
    exit;
}

// hash password
$hash_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO user (username, first_name, last_name, email, password)
          VALUES ('$username', '$first_name', '$last_name', '$email', '$hash_password')";

if (mysqli_query($koneksi, $query)) {
    echo "Registrasi berhasil! Yattaaa!";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>