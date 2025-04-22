<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NSacramento.php');

class PSacramentoEdit extends PBase
{
    private NSacramento $negocio;
    private array $sacramento;

    public function __construct()
    {
        parent::__construct("Editar Sacramento");

        $this->negocio = new NSacramento();

        if (!isset($_GET['id'])) {
            header("Location: PSacramentoList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = (int) $_GET['id'];
        $this->sacramento = $this->negocio->obtenerPorId($id);

        if (!$this->sacramento) {
            header("Location: PSacramentoList.php?msg=" . urlencode("Sacramento no encontrado."));
            exit;
        }

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocio->editar($_GET['id'], $_POST);
            header("Location: PSacramentoList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Editar Sacramento</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($this->sacramento['nombre']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"><?= htmlspecialchars($this->sacramento['descripcion']) ?></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PSacramentoList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PSacramentoEdit();
