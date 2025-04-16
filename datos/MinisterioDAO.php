<?php
require_once(__DIR__ . '/Conexion.php');

class MinisterioDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM ministerio ORDER BY nombre";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
