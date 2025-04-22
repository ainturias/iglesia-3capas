<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMembresia
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    // public function listar(): array
    // {
    //     $sql = "SELECT m.*, mb.nombre AS nombre_miembro, mb.apellido 
    //             FROM membresia m
    //             JOIN miembro mb ON m.id_miembro = mb.id_miembro";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function listar(): array
    {
        $sql = "SELECT m.*, mi.nombre, mi.apellido
            FROM membresia m
            JOIN miembro mi ON m.id_miembro = mi.id_miembro";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function crear(array $data): bool
    {
        $sql = "INSERT INTO membresia (tipo, fecha_inicio, fecha_fin, estado, id_miembro)
                VALUES (:tipo, :fecha_inicio, :fecha_fin, :estado, :id_miembro)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tipo' => $data['tipo'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            ':estado' => $data['estado'],
            ':id_miembro' => $data['id_miembro'],
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE membresia SET tipo = :tipo, fecha_inicio = :fecha_inicio,
                fecha_fin = :fecha_fin, estado = :estado, id_miembro = :id_miembro
                WHERE id_membresia = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tipo' => $data['tipo'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            ':estado' => $data['estado'],
            ':id_miembro' => $data['id_miembro'],
            ':id' => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM membresia WHERE id_membresia = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // public function obtenerPorId(int $id): ?array
    // {
    //     $sql = "SELECT * FROM membresia WHERE id_membresia = :id";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([':id' => $id]);
    //     $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $resultado ?: null;
    // }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT m.*, mi.nombre, mi.apellido
            FROM membresia m
            JOIN miembro mi ON m.id_miembro = mi.id_miembro
            WHERE m.id_membresia = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
