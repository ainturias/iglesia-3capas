<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DCurso
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    // public function listar(): array
    // {
    //     $stmt = $this->conn->prepare("SELECT * FROM curso");
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function listar(): array
    {
        $sql = "SELECT id_curso, nombre, descripcion, nivel, fecha_inicio, fecha_fin FROM curso";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO curso (nombre, descripcion, nivel, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['nivel'],
            $datos['fecha_inicio'],
            $datos['fecha_fin']
        ]);
    }

    public function insertar(array $data): bool
    {
        $sql = "INSERT INTO curso (nombre, descripcion, nivel, fecha_inicio, fecha_fin)
                VALUES (:nombre, :descripcion, :nivel, :fecha_inicio, :fecha_fin)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // public function editar(int $id, array $data): bool
    // {
    //     $sql = "UPDATE curso SET nombre = :nombre, descripcion = :descripcion,
    //             nivel = :nivel, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin
    //             WHERE id_curso = :id";
    //     $stmt = $this->conn->prepare($sql);
    //     $data['id'] = $id;
    //     return $stmt->execute($data);
    // }
    public function editar(int $id, array $datos): bool
    {
        $sql = "UPDATE curso SET nombre = ?, descripcion = ?, nivel = ?, fecha_inicio = ?, fecha_fin = ? WHERE id_curso = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['nivel'],
            $datos['fecha_inicio'],
            $datos['fecha_fin'],
            $id
        ]);
    }


    public function eliminar(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM curso WHERE id_curso = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM curso WHERE id_curso = ?");
        $stmt->execute([$id]);
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);
        return $curso ?: null;
    }

    public function obtenerMiembrosAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, CONCAT(m.nombre, ' ', m.apellido) AS nombre,
                       cm.nota, cm.fecha_inscripcion
                FROM curso_miembro cm
                JOIN miembro m ON cm.id_miembro = m.id_miembro
                WHERE cm.id_curso = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarMiembro(int $idCurso, int $idMiembro): bool
    {
        // Validar si ya está inscrito
        $sql = "SELECT * FROM curso_miembro WHERE id_curso = ? AND id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCurso, $idMiembro]);

        if ($stmt->fetch()) {
            return false; // Ya existe
        }

        $sql = "INSERT INTO curso_miembro (id_curso, id_miembro, fecha_inscripcion) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idCurso, $idMiembro]);
    }

    public function quitarMiembro(int $idCurso, int $idMiembro): bool
    {
        $sql = "DELETE FROM curso_miembro WHERE id_curso = ? AND id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idCurso, $idMiembro]);
    }

    public function calificarMiembro(int $idCurso, int $idMiembro, float $nota): bool
    {
        $sql = "UPDATE curso_miembro SET nota = ? WHERE id_curso = ? AND id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nota, $idCurso, $idMiembro]);
    }

    public function obtenerMiembrosNoAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, CONCAT(m.nombre, ' ', m.apellido) AS nombre
                FROM miembro m
                WHERE m.id_miembro NOT IN (
                    SELECT id_miembro FROM curso_miembro WHERE id_curso = ?
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
