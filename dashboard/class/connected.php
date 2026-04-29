<?php
// Connect ke database phpmyadmin!
class Connected {
    private $hostname = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "rental_app";

    public function connect() {
        $conn = new mysqli($this->hostname, $this->user, $this->pass, $this->db);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        return $conn;
    }
}