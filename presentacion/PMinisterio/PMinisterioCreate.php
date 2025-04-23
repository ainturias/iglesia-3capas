<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMinisterio.php');

class PMinisterioCreate extends PBase
{
    private NMinisterio $negocioMinisterio;

    public function __construct()
    {
        parent::__construct("Registrar Ministerio");
        $this->negocioMinisterio = new NMinisterio();

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMinisterio->crear($_POST);
            header("Location: PMinisterioList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
?>

        <h2>Registrar Nuevo Ministerio</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Creación</label>
                <input type="date" name="fecha_creacion" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="PMinisterioList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

<?php
        $this->renderFinCompleto();
    }
}

new PMinisterioCreate();
