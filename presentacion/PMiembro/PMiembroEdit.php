<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMiembroEdit extends PBase
{
    private NMiembro $negocioMiembro;
    private array $miembro;

    public function __construct()
    {
        parent::__construct("Editar Miembro");
        $this->negocioMiembro = new NMiembro();

        if (!isset($_GET['id'])) {
            header("Location: PMiembroList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = $_GET['id'];
        $this->miembro = $this->negocioMiembro->obtenerPorId($id);

        if (!$this->miembro) {
            header("Location: PMiembroList.php?msg=" . urlencode("Miembro no encontrado."));
            exit;
        }

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMiembro->editar($_GET['id'], $_POST);
            header("Location: PMiembroList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Editar Miembro</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= $this->miembro['nombre'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="<?= $this->miembro['apellido'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">CI</label>
                <input type="text" name="ci" class="form-control" value="<?= $this->miembro['ci'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $this->miembro['fecha_nacimiento'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="<?= $this->miembro['direccion'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="<?= $this->miembro['telefono'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="<?= $this->miembro['correo'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de Registro</label>
                <input type="date" name="fecha_registro" class="form-control" value="<?= $this->miembro['fecha_registro'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="activo" <?= $this->miembro['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $this->miembro['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PMiembroList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PMiembroEdit();
