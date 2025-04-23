<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMinisterio
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM ministerio";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO ministerio (nombre, descripcion, fecha_creacion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_creacion']
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE ministerio SET nombre = ?, descripcion = ?, fecha_creacion = ? WHERE id_ministerio = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_creacion'],
            $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM ministerio WHERE id_ministerio = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM ministerio WHERE id_ministerio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Miembros asignados al ministerio
    public function obtenerMiembrosAsignados(int $idMinisterio): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido, mm.fecha_ingreso
                FROM miembro m
                INNER JOIN miembro_ministerio mm ON m.id_miembro = mm.id_miembro
                WHERE mm.id_ministerio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idMinisterio]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Miembros NO asignados
    public function obtenerMiembrosNoAsignados(int $idMinisterio): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido
                FROM miembro m
                WHERE m.id_miembro NOT IN (
                    SELECT id_miembro FROM miembro_ministerio WHERE id_ministerio = ?
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idMinisterio]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarMiembro(int $idMinisterio, int $idMiembro, string $fecha): bool
    {
        $sql = "INSERT INTO miembro_ministerio (id_ministerio, id_miembro, fecha_ingreso)
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idMinisterio, $idMiembro, $fecha]);
    }

    public function quitarMiembro(int $idMinisterio, int $idMiembro): bool
    {
        $sql = "DELETE FROM miembro_ministerio WHERE id_ministerio = ? AND id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idMinisterio, $idMiembro]);
    }
}
