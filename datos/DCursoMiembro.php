<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DCursoMiembro
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexion::obtenerConexion();
    }

    // public function obtenerMiembrosAsignados(int $idCurso): array
    // {
    //     $sql = "SELECT m.id_miembro, CONCAT(m.nombre, ' ', m.apellido) AS nombre, cm.nota, cm.fecha_inscripcion
    //             FROM curso_miembro cm
    //             INNER JOIN miembro m ON cm.id_miembro = m.id_miembro
    //             WHERE cm.id_curso = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([$idCurso]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function obtenerMiembrosAsignados(int $idCurso): array
    // {
    //     $sql = "SELECT m.id_miembro, m.nombre, m.apellido, cm.nota, cm.fecha_inscripcion
    //         FROM curso_miembro cm
    //         JOIN miembro m ON cm.id_miembro = m.id_miembro
    //         WHERE cm.id_curso = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([$idCurso]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function obtenerMiembrosAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido, cm.nota, cm.fecha_inscripcion, cm.estado
            FROM miembro m
            INNER JOIN curso_miembro cm ON m.id_miembro = cm.id_miembro
            WHERE cm.id_curso = :idCurso";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idCurso' => $idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // public function obtenerMiembrosNoAsignados(int $idCurso): array
    // {
    //     $sql = "SELECT id_miembro, CONCAT(nombre, ' ', apellido) AS nombre
    //             FROM miembro
    //             WHERE id_miembro NOT IN (
    //                 SELECT id_miembro FROM curso_miembro WHERE id_curso = ?
    //             )";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([$idCurso]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function obtenerMiembrosNoAsignados(int $idCurso): array
    {
        $sql = "SELECT m.id_miembro, m.nombre, m.apellido
            FROM miembro m
            WHERE m.id_miembro NOT IN (
                SELECT id_miembro FROM curso_miembro WHERE id_curso = ?
            )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // public function asignar(int $idCurso, int $idMiembro, ?float $nota, ?string $fecha): bool
    // {
    //     $sql = "INSERT INTO curso_miembro (id_curso, id_miembro, nota, fecha_inscripcion) VALUES (?, ?, ?, ?)";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$idCurso, $idMiembro, $nota, $fecha]);
    // }

    // public function actualizarNota(int $idCurso, int $idMiembro, float $nota): bool
    // {
    //     $sql = "UPDATE curso_miembro SET nota = ? WHERE id_curso = ? AND id_miembro = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$nota, $idCurso, $idMiembro]);
    // }

    // public function quitar(int $idCurso, int $idMiembro): bool
    // {
    //     $sql = "DELETE FROM curso_miembro WHERE id_curso = ? AND id_miembro = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$idCurso, $idMiembro]);
    // }

    public function asignar(int $idCurso, int $idMiembro, ?float $nota = null, ?string $fecha = null): bool
    {
        $sql = "INSERT INTO curso_miembro (id_curso, id_miembro, nota, fecha_inscripcion)
            VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idCurso, $idMiembro, $nota, $fecha ?? date('Y-m-d')]);
    }

    public function quitar(int $idCurso, int $idMiembro): bool
    {
        $sql = "DELETE FROM curso_miembro WHERE id_curso = ? AND id_miembro = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idCurso, $idMiembro]);
    }

    // public function actualizarNota(int $idCurso, int $idMiembro, float $nota): bool
    // {
    //     $sql = "UPDATE curso_miembro SET nota = ? WHERE id_curso = ? AND id_miembro = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$nota, $idCurso, $idMiembro]);
    // }

    public function actualizarNota(int $idCurso, int $idMiembro, float $nota): bool
    {
        // Lógica del estado basada en la nota
        if ($nota >= 51) {
            $estado = 'aprobado';
        } elseif ($nota < 51) {
            $estado = 'reprobado';
        } else {
            $estado = 'pendiente';
        }

        $sql = "UPDATE curso_miembro 
            SET nota = :nota, estado = :estado 
            WHERE id_curso = :idCurso AND id_miembro = :idMiembro";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nota' => $nota,
            ':estado' => $estado,
            ':idCurso' => $idCurso,
            ':idMiembro' => $idMiembro
        ]);
    }
}
