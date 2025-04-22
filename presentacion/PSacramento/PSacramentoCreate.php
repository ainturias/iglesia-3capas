<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NSacramento.php');

class PSacramentoCreate extends PBase
{
    private NSacramento $negocioSacramento;

    public function __construct()
    {
        parent::__construct("Registrar Sacramento");
        $this->negocioSacramento = new NSacramento();
        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioSacramento->crear($_POST);
            header("Location: PSacramentoList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Registrar Sacramento</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <input type="text" name="descripcion" class="form-control">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Registrar</button>
                <a href="PSacramentoList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PSacramentoCreate();
