<?php
require_once(__DIR__ . '/../datos/CursoDAO.php');

class GestorCurso {
    private $dao;

    public function __construct() {
        $this->dao = new CursoDAO();
    }

    public function listarCursos() {
        return $this->dao->listarTodos();
    }

    // Aquí podrías agregar más funciones: registrarCurso, editarCurso, eliminarCurso
}
