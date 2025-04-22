<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DSacramento
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    // -------- CRUD SACRAMENTO --------
    public function listar(): array
    {
        $sql = "SELECT * FROM sacramento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar(array $data): bool
    {
        $sql = "INSERT INTO sacramento (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE sacramento SET nombre = :nombre, descripcion = :descripcion WHERE id_sacramento = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':id' => $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM sacramento WHERE id_sacramento = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM sacramento WHERE id_sacramento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    // -------- GESTIÓN DE SACRAMENTO RECIBIDO --------

    public function obtenerMiembrosAsignados(int $idSacramento): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido, sr.fecha, sr.lugar
                FROM sacramento_recibido sr
                JOIN miembro m ON sr.id_miembro = m.id_miembro
                WHERE sr.id_sacramento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idSacramento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMiembrosNoAsignados(int $idSacramento): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido
                FROM miembro m
                WHERE m.id_miembro NOT IN (
                    SELECT id_miembro FROM sacramento_recibido WHERE id_sacramento = :id
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idSacramento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarSacramento(int $idMiembro, int $idSacramento, string $fecha, string $lugar): bool
    {
        $sql = "INSERT INTO sacramento_recibido (id_miembro, id_sacramento, fecha, lugar)
                VALUES (:id_miembro, :id_sacramento, :fecha, :lugar)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_miembro' => $idMiembro,
            ':id_sacramento' => $idSacramento,
            ':fecha' => $fecha,
            ':lugar' => $lugar
        ]);
    }

    public function quitarSacramento(int $idMiembro, int $idSacramento): bool
    {
        $sql = "DELETE FROM sacramento_recibido 
                WHERE id_miembro = :id_miembro AND id_sacramento = :id_sacramento";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_miembro' => $idMiembro,
            ':id_sacramento' => $idSacramento
        ]);
    }
}
