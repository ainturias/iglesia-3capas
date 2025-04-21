<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMinisterio {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM ministerio ORDER BY nombre";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
