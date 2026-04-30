<?php
session_start();
include 'Connected.php';

class Pinjam {
    private $db;

    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
            header("Location: ../../login.html");
            exit;
        }
        
        $this->db = new Connected();
    }

    public function prosesPinjam($id) {
        $conn = $this->db->getConnection();
        
        // Menggunakan Prepared Statement untuk keamanan
        $stmt = $conn->prepare("UPDATE barang_sewa SET status = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}

if (isset($_GET['id'])) {
    $dipinjam = new Pinjam();
    
    if ($dipinjam->prosesPinjam($_GET['id'])) {
        echo "<script>alert('Barang berhasil dipinjam!'); window.location='../index.php?p=katalog';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan sistem.'); window.history.back();</script>";
    }
} else {
    header("Location: index.php");
    exit;
}
?>