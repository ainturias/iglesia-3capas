<?php
require_once(__DIR__ . '/../datos/DMiembro.php');
require_once(__DIR__ . '/../datos/DCursoMiembro.php');
require_once(__DIR__ . '/../datos/DMiembroMinisterio.php');

class NMiembro {
    private $dmiembro;

    public function __construct() {
        $this->dmiembro = new DMiembro();
    }

    public function listarMiembros() {
        return $this->dmiembro->listarConCursoYMinisterio();
    }


    public function registrarMiembro($data) {
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['ci']) || empty($data['fecha_nacimiento'])) {
            return "Faltan datos obligatorios.";
        }

        $miembro = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'ci' => $data['ci'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'direccion' => $data['direccion'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'correo' => $data['correo'] ?? null,
            'fecha_registro' => date('Y-m-d')
        ];

        $idMiembro = $this->dmiembro->insertarYRetornarID($miembro);

        if (!$idMiembro) return "Error al registrar miembro.";

        if (!empty($data['id_curso'])) {
            $dcursomiembro = new DCursoMiembro();
            $dcursomiembro->asignarCurso($idMiembro, $data['id_curso'], date('Y-m-d'), 0);
        }

        if (!empty($data['id_ministerio'])) {
            $dmiembroministerio = new DMiembroMinisterio();
            $dmiembroministerio->asignarMinisterio($idMiembro, $data['id_ministerio'], date('Y-m-d'));
        }

        return "Miembro registrado correctamente.";
    }

    public function eliminarMiembro($id) {
        return $this->dmiembro->eliminar($id);
    }

    
}
