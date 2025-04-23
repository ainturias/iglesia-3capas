<?php
require_once(__DIR__ . '/../datos/DMatrimonio.php');

class NMatrimonio
{
    private DMatrimonio $datos;

    public function __construct()
    {
        $this->datos = new DMatrimonio();
    }

    public function listar(): array
    {
        return $this->datos->listar();
    }

    public function registrar(array $data): string
    {
        return $this->datos->registrar($data)
            ? "Matrimonio registrado correctamente."
            : "Error al registrar el matrimonio.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Matrimonio actualizado correctamente."
            : "Error al actualizar el matrimonio.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Matrimonio eliminado correctamente."
            : "Error al eliminar el matrimonio. Verifique relaciones.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }
}
