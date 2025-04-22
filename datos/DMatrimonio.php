<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMatrimonio
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    public function listar(): array
    {
        $sql = "SELECT m.id_matrimonio, m.id_esposo, m.id_esposa, 
                       me1.nombre AS nombre_esposo, me1.apellido AS apellido_esposo,
                       me2.nombre AS nombre_esposa, me2.apellido AS apellido_esposa,
                       m.fecha, m.lugar, m.testigos
                FROM matrimonio m
                INNER JOIN miembro me1 ON m.id_esposo = me1.id_miembro
                INNER JOIN miembro me2 ON m.id_esposa = me2.id_miembro";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar(array $data): bool
    {
        $sql = "INSERT INTO matrimonio (id_esposo, id_esposa, fecha, lugar, testigos) 
                VALUES (:id_esposo, :id_esposa, :fecha, :lugar, :testigos)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_esposo' => $data['id_esposo'],
            ':id_esposa' => $data['id_esposa'],
            ':fecha' => $data['fecha'],
            ':lugar' => $data['lugar'],
            ':testigos' => $data['testigos'] ?? null,
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE matrimonio 
                SET id_esposo = :id_esposo, id_esposa = :id_esposa, fecha = :fecha, 
                    lugar = :lugar, testigos = :testigos
                WHERE id_matrimonio = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_esposo' => $data['id_esposo'],
            ':id_esposa' => $data['id_esposa'],
            ':fecha' => $data['fecha'],
            ':lugar' => $data['lugar'],
            ':testigos' => $data['testigos'] ?? null,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM matrimonio WHERE id_matrimonio = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM matrimonio WHERE id_matrimonio = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $matrimonio = $stmt->fetch(PDO::FETCH_ASSOC);
        return $matrimonio ?: null;
    }
}
