<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DCurso
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    // --- CRUD de Curso ---
    public function listar(): array
    {
        $sql = "SELECT * FROM curso";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar(array $data): bool
    {
        $sql = "INSERT INTO curso (nombre, descripcion, nivel, fecha_inicio, fecha_fin) 
                VALUES (:nombre, :descripcion, :nivel, :fecha_inicio, :fecha_fin)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':nivel' => $data['nivel'] ?? null,
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin']
        ]);
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE curso SET nombre = :nombre, descripcion = :descripcion, nivel = :nivel, 
                fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id_curso = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':nivel' => $data['nivel'] ?? null,
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            ':id' => $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM curso WHERE id_curso = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM curso WHERE id_curso = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // --- Lógica de curso_miembro ---
    public function obtenerMiembrosAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido, cm.nota, cm.fecha_inscripcion, cm.estado
                FROM curso_miembro cm
                INNER JOIN miembro m ON cm.id_miembro = m.id_miembro
                WHERE cm.id_curso = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMiembrosNoAsignados(int $idCurso): array
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

    public function asignarMiembro(int $idCurso, int $idMiembro, ?float $nota, string $fecha): bool
    {
        $estado = 'pendiente';
        if (is_numeric($nota)) {
            $estado = $nota >= 51 ? 'aprobado' : 'reprobado';
        }

        $sql = "INSERT INTO curso_miembro (id_miembro, id_curso, nota, fecha_inscripcion, estado)
                VALUES (:id_miembro, :id_curso, :nota, :fecha, :estado)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_miembro' => $idMiembro,
            ':id_curso' => $idCurso,
            ':nota' => $nota,
            ':fecha' => $fecha,
            ':estado' => $estado
        ]);
    }

    public function quitarMiembro(int $idCurso, int $idMiembro): bool
    {
        $sql = "DELETE FROM curso_miembro WHERE id_miembro = :id_miembro AND id_curso = :id_curso";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_miembro' => $idMiembro,
            ':id_curso' => $idCurso
        ]);
    }

    public function calificarMiembro(int $idCurso, int $idMiembro, float $nota): bool
    {
        $estado = $nota >= 51 ? 'aprobado' : 'reprobado';

        $sql = "UPDATE curso_miembro SET nota = :nota, estado = :estado 
                WHERE id_miembro = :id_miembro AND id_curso = :id_curso";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nota' => $nota,
            ':estado' => $estado,
            ':id_miembro' => $idMiembro,
            ':id_curso' => $idCurso
        ]);
    }
}
