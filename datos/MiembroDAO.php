<?php
require_once(__DIR__ . '/Conexion.php');

class MiembroDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function insertar($miembro) {
        $sql = "INSERT INTO miembro (nombre, apellido, ci, fecha_nacimiento, direccion, telefono, correo, fecha_registro)
        VALUES (:nombre, :apellido, :ci, :fecha_nacimiento, :direccion, :telefono, :correo, :fecha_registro)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($miembro);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM miembro WHERE id_miembro = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function listarTodos() {
        $sql = "SELECT * FROM miembro ORDER BY id_miembro DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
