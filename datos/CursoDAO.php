<?php
require_once(__DIR__ . '/Conexion.php');

class CursoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM curso ORDER BY nombre";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
