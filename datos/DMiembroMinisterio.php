<?php
require_once(__DIR__ . '/../conexion/Conexion.php');

class DMiembroMinisterio {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function asignarMinisterio($idMiembro, $idMinisterio, $fechaIngreso) {
        $sql = "INSERT INTO miembro_ministerio (id_miembro, id_ministerio, fecha_ingreso)
                VALUES (:id_miembro, :id_ministerio, :fecha_ingreso)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id_miembro' => $idMiembro,
            'id_ministerio' => $idMinisterio,
            'fecha_ingreso' => $fechaIngreso
        ]);
    }
}
