<?php
require_once(__DIR__ . '/../datos/DSacramento.php');

class NSacramento
{
    private DSacramento $datos;

    public function __construct()
    {
        $this->datos = new DSacramento();
    }

    // -------- SACRAMENTO --------
    public function listar(): array
    {
        return $this->datos->listar();
    }

    public function crear(array $data): string
    {
        return $this->datos->insertar($data)
            ? "Sacramento registrado correctamente."
            : "Error al registrar el sacramento.";
    }

    public function editar(int $id, array $data): string
    {
        return $this->datos->editar($id, $data)
            ? "Sacramento actualizado correctamente."
            : "Error al actualizar el sacramento.";
    }

    public function eliminar(int $id): string
    {
        return $this->datos->eliminar($id)
            ? "Sacramento eliminado correctamente."
            : "No se pudo eliminar el sacramento. Verifica relaciones.";
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->datos->obtenerPorId($id);
    }

    // -------- SACRAMENTO RECIBIDO --------

    public function asignarSacramentoAmiembro(int $idMiembro, int $idSacramento, string $fecha, string $lugar): string
    {
        return $this->datos->asignarSacramento($idMiembro, $idSacramento, $fecha, $lugar)
            ? "Sacramento asignado correctamente."
            : "Error al asignar sacramento. Es posible que ya esté registrado.";
    }

    public function quitarSacramento(int $idMiembro, int $idSacramento): string
    {
        return $this->datos->quitarSacramento($idMiembro, $idSacramento)
            ? "Sacramento quitado correctamente."
            : "No se pudo quitar el sacramento.";
    }

    public function obtenerMiembrosConSacramento(int $idSacramento): array
    {
        return $this->datos->obtenerMiembrosAsignados($idSacramento);
    }

    public function obtenerMiembrosSinSacramento(int $idSacramento): array
    {
        return $this->datos->obtenerMiembrosNoAsignados($idSacramento);
    }
}
