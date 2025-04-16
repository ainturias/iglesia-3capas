<?php
require_once(__DIR__ . '/../datos/MinisterioDAO.php');

class GestorMinisterio {
    private $dao;

    public function __construct() {
        $this->dao = new MinisterioDAO();
    }

    public function listarMinisterios() {
        return $this->dao->listarTodos();
    }

    // Aquí podrías agregar más funciones: registrarMinisterio, editarMinisterio, eliminarMinisterio
}
