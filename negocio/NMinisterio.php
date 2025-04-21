<?php
require_once(__DIR__ . '/../datos/DMinisterio.php');

class NMinisterio {
    private $dao;

    public function __construct() {
        $this->dao = new DMinisterio();
    }

    public function listarMinisterios() {
        return $this->dao->listarTodos();
    }

    // Aquí podrías agregar más funciones: registrarMinisterio, editarMinisterio, eliminarMinisterio
}
