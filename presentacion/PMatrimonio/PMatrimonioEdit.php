<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMatrimonio.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMatrimonioEdit extends PBase
{
    private NMatrimonio $negocioMatrimonio;
    private NMiembro $negocioMiembro;
    private array $matrimonio;

    public function __construct()
    {
        parent::__construct("Editar Matrimonio");

        $this->negocioMatrimonio = new NMatrimonio();
        $this->negocioMiembro = new NMiembro();

        if (!isset($_GET['id'])) {
            header("Location: PMatrimonioList.php?msg=" . urlencode("ID no especificado."));
            exit;
        }

        $id = (int)$_GET['id'];
        $this->matrimonio = $this->negocioMatrimonio->obtenerPorId($id);

        if (!$this->matrimonio) {
            header("Location: PMatrimonioList.php?msg=" . urlencode("Matrimonio no encontrado."));
            exit;
        }

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMatrimonio->editar($_GET['id'], $_POST);
            header("Location: PMatrimonioList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        $miembros = $this->negocioMiembro->listar();
?>

        <h2>Editar Matrimonio</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Esposo</label>
                <select name="id_esposo" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <?php foreach ($miembros as $miembro): ?>
                        <option value="<?= $miembro['id_miembro'] ?>"
                            <?= $miembro['id_miembro'] == $this->matrimonio['id_esposo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($miembro['nombre'] . ' ' . $miembro['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Esposa</label>
                <select name="id_esposa" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <?php foreach ($miembros as $miembro): ?>
                        <option value="<?= $miembro['id_miembro'] ?>"
                            <?= $miembro['id_miembro'] == $this->matrimonio['id_esposa'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($miembro['nombre'] . ' ' . $miembro['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control"
                    value="<?= $this->matrimonio['fecha'] ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Lugar</label>
                <input type="text" name="lugar" class="form-control"
                    value="<?= htmlspecialchars($this->matrimonio['lugar']) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Testigos</label>
                <input type="text" name="testigos" class="form-control"
                    value="<?= htmlspecialchars($this->matrimonio['testigos']) ?>">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="PMatrimonioList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

<?php
        $this->renderFinCompleto();
    }
}

new PMatrimonioEdit();
