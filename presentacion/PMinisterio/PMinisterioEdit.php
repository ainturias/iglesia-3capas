<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMinisterio.php');

class PMinisterioEdit extends PBase
{
    private NMinisterio $negocioMinisterio;
    private array $ministerio;

    public function __construct()
    {
        parent::__construct("Editar Ministerio");
        $this->negocioMinisterio = new NMinisterio();

        if (!isset($_GET['id'])) {
            header("Location: PMinisterioList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = (int) $_GET['id'];
        $this->ministerio = $this->negocioMinisterio->obtenerPorId($id);

        if (!$this->ministerio) {
            header("Location: PMinisterioList.php?msg=" . urlencode("Ministerio no encontrado."));
            exit;
        }

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMinisterio->editar($_GET['id'], $_POST);
            header("Location: PMinisterioList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Editar Ministerio</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($this->ministerio['nombre']) ?>" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($this->ministerio['descripcion']) ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Creación</label>
                <input type="date" name="fecha_creacion" class="form-control" value="<?= $this->ministerio['fecha_creacion'] ?>" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PMinisterioList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PMinisterioEdit();
