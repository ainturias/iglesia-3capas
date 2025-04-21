<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NCurso.php');

class PCursoCreate extends PBase
{
    private NCurso $negocioCurso;

    public function __construct()
    {
        parent::__construct("Registrar Curso");
        $this->negocioCurso = new NCurso();
        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'nivel' => $_POST['nivel'] ?? '',
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
            ];

            $mensaje = $this->negocioCurso->crear($data);
            header("Location: ../PCurso/PCursoList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Registrar Nuevo Curso</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nivel</label>
                <input type="text" name="nivel" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha Final</label>
                <input type="date" name="fecha_fin" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Guardar Curso</button>
                <a href="PCursoList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PCursoCreate();
