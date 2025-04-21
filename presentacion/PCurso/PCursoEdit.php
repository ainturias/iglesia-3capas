<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NCurso.php');

class PCursoEdit extends PBase
{
    private NCurso $negocioCurso;
    private array $curso;

    public function __construct()
    {
        parent::__construct("Editar Curso");
        $this->negocioCurso = new NCurso();

        if (!isset($_GET['id'])) {
            header("Location: PCursoList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = (int) $_GET['id'];
        $this->curso = $this->negocioCurso->obtenerPorId($id);

        if (!$this->curso) {
            header("Location: PCursoList.php?msg=" . urlencode("Curso no encontrado."));
            exit;
        }

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioCurso->editar($_GET['id'], $_POST);
            header("Location: PCursoList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
?>

        <h2>Editar Curso</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre del Curso</label>
                <input type="text" name="nombre" class="form-control" value="<?= $this->curso['nombre'] ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nivel</label>
                <input type="text" name="nivel" class="form-control" value="<?= $this->curso['nivel'] ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= $this->curso['descripcion'] ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" value="<?= $this->curso['fecha_inicio'] ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Fecha Final</label>
                <input type="date" name="fecha_fin" class="form-control" value="<?= $this->curso['fecha_fin'] ?>" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PCursoList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

<?php
        $this->renderFinCompleto();
    }
}

new PCursoEdit();
