<?php
include 'Connected.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username     = $_POST['username'];
    $first_name   = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $email        = $_POST['email'];
    $password     = $_POST['password'];
    $con_password = $_POST['con_password'];

    // Validasi password
    if ($password !== $con_password) {
        die("Password tidak sama!");
    }

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke database
    $query = "INSERT INTO users 
        (username, first_name, last_name, email, password) 
        VALUES 
        ('$username','$first_name','$last_name','$email','$hash')";

    if (mysqli_query($koneksi, $query)) {
        echo "Registrasi berhasil!";
        header("Location: ../login.html");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>