<?php
require_once(__DIR__ . '/../datos/DMinisterio.php');

class NMinisterio
{
    private DMinisterio $datos;

    public function __construct()
    {
        $this->datos = new DMinisterio();
    }

    public function listar(): array
    {
        return $this->datos->listar();
    }

    public function crear(array $data): string
    {
        return $this->datos->insertar($data)
            ? "Ministerio registrado correctamente."
            : "Error al registrar ministerio.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Ministerio actualizado correctamente."
            : "Error al actualizar ministerio.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Ministerio eliminado correctamente."
            : "No se pudo eliminar. Verifica relaciones.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }

    // Gestión de asignaciones

    public function asignarMiembro(int $idMinisterio, int $idMiembro, string $fechaIngreso): bool
    {
        return $this->datos->asignarMiembro($idMinisterio, $idMiembro, $fechaIngreso);
    }

    public function quitarMiembro(int $idMinisterio, int $idMiembro): bool
    {
        return $this->datos->quitarMiembro($idMinisterio, $idMiembro);
    }

    public function obtenerMiembrosAsignados(int $idMinisterio): array
    {
        return $this->datos->obtenerMiembrosAsignados($idMinisterio);
    }

    public function obtenerMiembrosNoAsignados(int $idMinisterio): array
    {
        return $this->datos->obtenerMiembrosNoAsignados($idMinisterio);
    }
}
