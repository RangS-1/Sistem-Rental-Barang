<?php
class Connected {
    private $hostname = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "rentalin";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli(
                $this->hostname, 
                $this->user, 
                $this->pass, 
                $this->db);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}