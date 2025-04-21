<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMiembro {
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
    
    public function insertarYRetornarID($miembro) {
        $sql = "INSERT INTO miembro (nombre, apellido, ci, fecha_nacimiento, direccion, telefono, correo, fecha_registro)
                VALUES (:nombre, :apellido, :ci, :fecha_nacimiento, :direccion, :telefono, :correo, :fecha_registro)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($miembro);
        return $this->conn->lastInsertId();
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

    public function listarConCursoYMinisterio() {
        $sql = "
            SELECT 
                m.*,
                c.nombre AS curso_nombre,
                mi.nombre AS ministerio_nombre
            FROM miembro m
            LEFT JOIN curso_miembro cm ON m.id_miembro = cm.id_miembro
            LEFT JOIN curso c ON cm.id_curso = c.id_curso
            LEFT JOIN miembro_ministerio mm ON m.id_miembro = mm.id_miembro
            LEFT JOIN ministerio mi ON mm.id_ministerio = mi.id_ministerio
            ORDER BY m.id_miembro DESC
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
