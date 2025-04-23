<?php
require_once(__DIR__ . '/../datos/DMiembro.php');

class NMiembro
{
    private DMiembro $datos;

    public function __construct()
    {
        $this->datos = new DMiembro();
    }

    public function listar(): array
    {
        return $this->datos->listar();
    }

    public function registrar(array $data): string
    {
        return $this->datos->insertar($data)
            ? "Miembro registrado correctamente."
            : "Error al registrar miembro.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Miembro actualizado correctamente."
            : "Error al actualizar miembro.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Miembro eliminado correctamente."
            : "No se pudo eliminar el miembro. Verifique que no tenga relaciones activas.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }

    // ---------------------------------------------------------------------
    // --- Métodos adicionales para obtener cursos y ministerios por miembro ---
    public function obtenerCursosPorMiembro(int $id): array
    {
        return $this->datos->obtenerCursosPorMiembro($id);
    }

    public function obtenerMinisteriosPorMiembro(int $id): array
    {
        return $this->datos->obtenerMinisteriosPorMiembro($id);
    }

    // ---------------------------------------------------------------------
    // Nuevo de Curso
    public function listarNoAsignados(int $idCurso): array
    {
        return $this->datos->listarNoAsignados($idCurso);
    }

    public function listarAsignados(int $idCurso): array
    {
        return $this->datos->listarAsignados($idCurso);
    }
}
