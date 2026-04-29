<?php
session_start();
include 'Connected.php';

// Ambil class Connected di Connected.php
$db = new Connected();
$conn = $db->conn;

if (isset($_POST['login'])) {

    $name = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // 4. Redirect berdasarkan role
        if ($user['role'] == 'admin') {
            header("Location: ../dashboard-admin.php");
            exit;
        } else {
            header("Location: ../index.php");
            exit;
        }

    } else {
        echo "<script>alert('Login gagal! Username atau password salah.'); window.history.back();</script>";
    }
    
    $stmt->close();
}
?>