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
        $stmt = $this->conn->prepare($sql);     //stmt = statement //declaracion de la consulta
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
        try {
            $sql = "DELETE FROM miembro WHERE id_miembro = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM miembro WHERE id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public function obtenerCursosPorMiembro(int $id): array
    {
        $sql = "SELECT c.nombre, cm.nota, cm.fecha_inscripcion
            FROM curso_miembro cm
            JOIN curso c ON cm.id_curso = c.id_curso
            WHERE cm.id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMinisteriosPorMiembro(int $id): array
    {
        $sql = "SELECT m.nombre, mm.fecha_ingreso
            FROM miembro_ministerio mm
            JOIN ministerio m ON mm.id_ministerio = m.id_ministerio
            WHERE mm.id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NUEVO DE CURSOS
    public function listarNoAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido 
                FROM miembro m
                WHERE m.id_miembro NOT IN (
                    SELECT id_miembro FROM curso_miembro WHERE id_curso = :id
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido, cm.nota, cm.fecha_inscripcion, cm.estado
                FROM curso_miembro cm
                INNER JOIN miembro m ON cm.id_miembro = m.id_miembro
                WHERE cm.id_curso = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
