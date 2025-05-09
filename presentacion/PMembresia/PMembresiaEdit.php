<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMembresia.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMembresiaEdit extends PBase
{
    private NMembresia $negocioMembresia;
    private NMiembro $negocioMiembro;
    private array $membresia;
    private array $miembro;

    public function __construct()
    {
        parent::__construct("Editar Membresía");
        $this->negocioMembresia = new NMembresia();
        $this->negocioMiembro = new NMiembro();

        $this->validarMembresiaDesdeURL();
        $this->procesarFormulario();
        $this->mostrarVista();
    }

    // Valida el ID desde la URL y obtiene los datos de la membresía
    private function validarMembresiaDesdeURL(): void
    {
        if (!isset($_GET['id'])) {
            header("Location: PMembresiaList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = (int)$_GET['id'];
        $this->membresia = $this->negocioMembresia->obtenerPorId($id);

        if (!$this->membresia) {
            header("Location: PMembresiaList.php?msg=" . urlencode("Membresía no encontrada."));
            exit;
        }

        $this->miembro = $this->negocioMiembro->obtenerPorId($this->membresia['id_miembro']) ?? ['nombre' => 'Desconocido', 'apellido' => ''];
    }

    // Procesa los cambios enviados desde el formulario
    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMembresia->editar($this->membresia['id_membresia'], $_POST);
            header("Location: PMembresiaList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    // Muestra el formulario con los datos existentes
    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
?>

        <h2>Editar Membresía</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Miembro</label>
                <input type="hidden" name="id_miembro" value="<?= $this->membresia['id_miembro'] ?>">
                <input type="text" class="form-control" value="<?= htmlspecialchars($this->miembro['nombre'] . ' ' . $this->miembro['apellido']) ?>" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tipo</label>
                <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($this->membresia['tipo']) ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" value="<?= $this->membresia['fecha_inicio'] ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Fecha de Fin</label>
                <input type="date" name="fecha_fin" class="form-control" value="<?= $this->membresia['fecha_fin'] ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="activa" <?= $this->membresia['estado'] === 'activa' ? 'selected' : '' ?>>Activa</option>
                    <option value="inactiva" <?= $this->membresia['estado'] === 'inactiva' ? 'selected' : '' ?>>Inactiva</option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PMembresiaList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

<?php
        $this->renderFinCompleto();
    }
}

new PMembresiaEdit();
