<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMiembroCreate extends PBase
{
    private NMiembro $negocioMiembro;

    public function __construct()
    {
        parent::__construct("Registrar Miembro");
        $this->negocioMiembro = new NMiembro();
        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMiembro->registrarMiembro($_POST);
            header("Location: PMiembroList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Registrar Nuevo Miembro</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Apellido</label><input type="text" name="apellido" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">CI</label><input type="text" name="ci" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Dirección</label><input type="text" name="direccion" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Teléfono</label><input type="text" name="telefono" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="correo" class="form-control"></div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="PMiembroList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PMiembroCreate();
