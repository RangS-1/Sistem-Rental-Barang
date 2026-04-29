<?php
session_start();
include 'Connected.php';

class Pinjam {
    private $db;

    public function __construct() {
        // Proteksi: Pastikan hanya user yang bisa mengakses fungsionalitas ini
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
            header("Location: ../../login.html");
            exit;
        }
        
        $this->db = new Connected();
    }

    public function prosesPinjam($id) {
        $conn = $this->db->getConnection();
        
        // Menggunakan Prepared Statement untuk keamanan
        $stmt = $conn->prepare("UPDATE barang_sewa SET status = 0 WHERE id_barang = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;

?>