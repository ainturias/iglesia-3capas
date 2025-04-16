<?php
require_once(__DIR__ . '/../datos/MiembroDAO.php');

class GestorMiembro {
    private $dao;

    public function __construct() {
        $this->dao = new MiembroDAO();
    }

    public function registrarMiembro($data) {
        // Validar campos obligatorios
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['ci']) || empty($data['fecha_nacimiento'])) {
            return "Faltan datos obligatorios.";
        }

        // Crear array con los datos
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

        // Insertar
        $exito = $this->dao->insertar($miembro);
        return $exito ? "Miembro registrado correctamente." : "Error al registrar miembro.";
    }

    public function eliminarMiembro($id) {
        return $this->dao->eliminar($id);
    }

    public function listarMiembros() {
        return $this->dao->listarTodos();
    }
}
