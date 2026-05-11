<?php
session_start();
include 'Connected.php';

class Penyewaan {
    private $db;

    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
            header("Location: ../../login.html");
            exit;
        }
        
        $this->db = new Connected();
    }

    public function prosesPinjam($id, $alamat) {
        $conn = $this->db->getConnection();
        $user_id = $_SESSION['user_id'];
        $alamat = $_GET['alamat'] ?? null;
        
        $stmt = $conn->prepare(
            "UPDATE barang_sewa
            SET status = 0,
                peminjam = ?,
                alamat = ?
            WHERE id = ?"
        );

        $stmt->bind_param(
            "isi",
            $user_id,
            $alamat,
            $id
        );

        return $stmt->execute();
    }
}

if (isset($_GET['id'])) {
    $dipinjam = new Penyewaan();
    
    if ($dipinjam->prosesPinjam($_GET['id'], $_GET['alamat'])) {
        echo "<script>alert('Barang berhasil dipinjam!'); window.location='../index.php?p=katalog';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan sistem.'); window.history.back();</script>";
    }
} else {
    header("Location: index.php");
    exit;
}
?>