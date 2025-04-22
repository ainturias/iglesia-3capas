<?php
require_once(__DIR__ . '/../datos/DMembresia.php');

class NMembresia
{
    private DMembresia $datos;

    public function __construct()
    {
        $this->datos = new DMembresia();
    }

    public function listar(): array
    {
        return $this->datos->listar();
    }

    public function crear(array $data): string
    {
        return $this->datos->crear($data)
            ? "Membresía registrada correctamente."
            : "Error al registrar la membresía.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Membresía actualizada correctamente."
            : "Error al actualizar la membresía.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Membresía eliminada correctamente."
            : "No se pudo eliminar la membresía.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }
}
