<?php
require_once(__DIR__ . '/../../negocio/NMiembro.php');
require_once(__DIR__ . '/../../includes/head.php');
require_once(__DIR__ . '/../../includes/navbar.php');

class PMiembroCreate
{
    private $nmiembro;

    public function __construct()
    {
        $this->nmiembro = new NMiembro();
        $this->procesarFormulario();
        $this->mostrarFormulario();
    }

    private function procesarFormulario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->nmiembro->registrarMiembro($_POST);
            header("Location: PMiembroList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarFormulario()
    {
?>
        <div class="container mt-4">
            <h2>Registrar Nuevo Miembro</h2>

            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">CI</label>
                    <input type="text" name="ci" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="PMiembroList.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    }
}

new PMiembroCreate();
