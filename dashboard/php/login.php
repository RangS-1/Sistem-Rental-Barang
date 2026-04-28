<?php
session_start();
include 'connected.php';

if (isset($_POST['login'])) {

    $name = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$name'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: dashboard-admin.php");
            exit;
        } else {
            header("Location: dashboard-user.php");
            exit;
        }

    } else {
        echo "Login gagal";
    }
}
?>