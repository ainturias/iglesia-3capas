<?php
require_once(__DIR__ . '/../datos/DCurso.php');
require_once(__DIR__ . '/../datos/DCursoMiembro.php');

class NCurso
{
    private $dc;
    private $dcm;

    public function __construct()
    {
        $this->dc = new DCurso();
        $this->dcm = new DCursoMiembro();
    }

    public function listarCursos(): array
    {
        return $this->dc->listar();
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->dc->obtenerPorId($id);
    }

    public function crear(array $datos): bool
    {
        return $this->dc->crear($datos);
    }

    public function editar(int $id, array $datos): bool
    {
        return $this->dc->editar($id, $datos);
    }

    public function eliminar(int $id): bool
    {
        return $this->dc->eliminar($id);
    }

    public function obtenerMiembrosAsignados(int $idCurso): array
    {
        return $this->dcm->obtenerMiembrosAsignados($idCurso);
    }

    public function obtenerMiembrosNoAsignados(int $idCurso): array
    {
        return $this->dcm->obtenerMiembrosNoAsignados($idCurso);
    }

    public function asignarMiembro(int $idCurso, int $idMiembro, ?float $nota, ?string $fecha): bool
    {
        return $this->dcm->asignar($idCurso, $idMiembro, $nota, $fecha);
    }

    public function calificarMiembro(int $idCurso, int $idMiembro, float $nota): bool
    {
        return $this->dcm->actualizarNota($idCurso, $idMiembro, $nota);
    }

    public function quitarMiembro(int $idCurso, int $idMiembro): bool
    {
        return $this->dcm->quitar($idCurso, $idMiembro);
    }
}
