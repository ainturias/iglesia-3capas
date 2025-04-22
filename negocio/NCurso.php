<?php
require_once(__DIR__ . '/../datos/DCurso.php');

class NCurso
{
    private DCurso $datos;

    public function __construct()
    {
        $this->datos = new DCurso();
    }

    public function listarCursos(): array
    {
        return $this->datos->listar();
    }

    public function crear(array $data): string
    {
        return $this->datos->insertar($data)
            ? "Curso registrado correctamente."
            : "Error al registrar el curso.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Curso actualizado correctamente."
            : "Error al actualizar el curso.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Curso eliminado correctamente."
            : "No se pudo eliminar el curso. Verifica relaciones.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }

    // --- Asignación de miembros al curso (ahora dentro de DCurso) ---

    public function obtenerMiembrosAsignados(int $idCurso): array
    {
        return $this->datos->obtenerMiembrosAsignados($idCurso);
    }

    public function obtenerMiembrosNoAsignados(int $idCurso): array
    {
        return $this->datos->obtenerMiembrosNoAsignados($idCurso);
    }

    // public function asignarMiembro(int $idCurso, int $idMiembro, string $fecha = null): string
    // {
    //     return $this->datos->asignarMiembro($idCurso, $idMiembro, $fecha)
    //         ? "Miembro asignado al curso."
    //         : "Error al asignar miembro o ya está asignado.";
    // }
    public function asignarMiembro(int $idCurso, int $idMiembro, ?float $nota, string $fecha): string
    {
        return $this->datos->asignarMiembro($idCurso, $idMiembro, $nota, $fecha)
            ? "Miembro asignado al curso."
            : "Error al asignar miembro o ya está asignado.";
    }


    public function quitarMiembro(int $idCurso, int $idMiembro): string
    {
        return $this->datos->quitarMiembro($idCurso, $idMiembro)
            ? "Miembro retirado del curso."
            : "No se pudo retirar al miembro.";
    }

    public function calificarMiembro(int $idCurso, int $idMiembro, float $nota): string
    {
        return $this->datos->calificarMiembro($idCurso, $idMiembro, $nota)
            ? "Miembro calificado correctamente."
            : "Error al calificar.";
    }
}
