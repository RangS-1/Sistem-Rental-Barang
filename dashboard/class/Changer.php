<?php
// Fungsi untuk ubah data
class Changer {
    private $conn;
    private $table = "barang_sewa";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create($data, $file) {
        $nama = $data['nama_barang'];
        $harga = $data['harga'];
        $deskripsi = $data['deskripsi'];

        $gambar = time() . "_" . $file['gambar']['name'];
        $tmp = $file['gambar']['tmp_name'];

        move_uploaded_file($tmp, "../../uploads/" . $gambar);

        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
            (nama_barang, deskripsi, harga_per_hari, gambar, status)
            VALUES (?, ?, ?, ?, 1)"
        );

        $stmt->bind_param("ssis", $nama, $deskripsi, $harga, $gambar);
        return $stmt->execute();
    }

    // READ ALL
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM {$this->table}");
        return $result;
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // UPDATE STATUS
    public function toggleStatus($id) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} 
             SET status = NOT status 
             WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // UPDATE DATA
    public function update($id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET nama_barang=?, deskripsi=?, harga_per_hari=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "ssii",
            $data['nama_barang'],
            $data['deskripsi'],
            $data['harga'],
            $id
        );

        return $stmt->execute();
    }

    // GET BY ID
    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}