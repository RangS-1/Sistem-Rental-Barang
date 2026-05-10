<?php
// Mengontrol operasi Barang.php
require_once 'Connected.php';
require_once 'Barang.php';

$db = new Connected();
$conn = $db->getConnection();

class Control {
    private $barang;

    public function __construct() {
        $db = (new Connected())->GetConnection();
        $this->barang = new Barang($db);
    }

    public function handleRequest() {

        if (isset($_POST['tambah_barang'])) {
            $this->barang->create($_POST, $_FILES);
        }

        if (isset($_GET['hapus'])) {
            $this->barang->delete($_GET['hapus']);
        }

        if (isset($_GET['toggle_status'])) {
            $this->barang->toggleStatus($_GET['toggle_status']);
        }

        if (isset($_POST['update_barang'])) {
            $this->barang->update($_POST['id'], $_POST);
        }
    }

    public function index() {
        return $this->barang->getAll();
    }

    public function show($id) {
        return $this->barang->getById($id);
    }
}