<?php
require_once(__DIR__ . '/../datos/DMiembro.php');

class NMiembro
{
    private DMiembro $datos;

    public function __construct()
    {
        $this->datos = new DMiembro();
    }

    public function listarMiembros(): array
    {
        return $this->datos->listar();
    }

    public function registrarMiembro(array $data): string
    {
        return $this->datos->insertar($data)
            ? "Miembro registrado correctamente."
            : "Error al registrar miembro.";
    }

    public function editarMiembro(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Miembro actualizado correctamente."
            : "Error al actualizar miembro.";
    }

    public function eliminarMiembro(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Miembro eliminado correctamente."
            : "No se pudo eliminar el miembro. Verifica relaciones.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }

    public function obtenerCursosPorMiembro($id)
    {
        return $this->datos->obtenerCursosPorMiembro($id);
    }

    public function obtenerMinisteriosPorMiembro($id)
    {
        return $this->datos->obtenerMinisteriosPorMiembro($id);
    }
}
