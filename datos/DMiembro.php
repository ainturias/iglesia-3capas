<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMiembro
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM miembro";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar(array $data): bool
    {
        $sql = "INSERT INTO miembro (nombre, apellido, ci, fecha_nacimiento, direccion, telefono, correo, fecha_registro, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'activo')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['ci'],
            $data['fecha_nacimiento'],
            $data['direccion'] ?? null,
            $data['telefono'] ?? null,
            $data['correo'] ?? null
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE miembro SET nombre = ?, apellido = ?, ci = ?, fecha_nacimiento = ?, direccion = ?, telefono = ?, correo = ?, estado = ? 
                WHERE id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['ci'],
            $data['fecha_nacimiento'],
            $data['direccion'] ?? null,
            $data['telefono'] ?? null,
            $data['correo'] ?? null,
            $data['estado'] ?? 'activo',
            $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM miembro WHERE id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM miembro WHERE id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public function obtenerCursosPorMiembro($id)
    {
        $sql = "SELECT c.nombre, cm.nota, cm.fecha_inscripcion
            FROM curso_miembro cm
            JOIN curso c ON cm.id_curso = c.id_curso
            WHERE cm.id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMinisteriosPorMiembro($id)
    {
        $sql = "SELECT m.nombre, mm.fecha_ingreso
            FROM miembro_ministerio mm
            JOIN ministerio m ON mm.id_ministerio = m.id_ministerio
            WHERE mm.id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
