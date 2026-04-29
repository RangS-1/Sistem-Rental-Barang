<?php
include 'Connected.php';

$db = new Connected();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username     = $_POST['username'];
    $first_name   = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $email        = $_POST['email'];
    $password     = $_POST['password'];
    $con_password = $_POST['con_password'];

    if ($password !== $con_password) {
        die("Password tidak sama!");
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $first_name, $last_name, $email, $hash);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil!'); window.location='../../login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>