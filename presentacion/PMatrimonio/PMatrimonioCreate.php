<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMatrimonio.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMatrimonioCreate extends PBase
{
    private NMatrimonio $negocioMatrimonio;
    private NMiembro $negocioMiembro;

    public function __construct()
    {
        parent::__construct("Registrar Matrimonio");

        $this->negocioMatrimonio = new NMatrimonio();
        $this->negocioMiembro = new NMiembro();

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMatrimonio->registrar($_POST);
            header("Location: PMatrimonioList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        $miembros = $this->negocioMiembro->listarMiembros();
        ?>

        <h2>Registrar Matrimonio</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Esposo</label>
                <select name="id_esposo" class="form-select" required>
                    <option value="">-- Seleccione al esposo --</option>
                    <?php foreach ($miembros as $m): ?>
                        <option value="<?= $m['id_miembro'] ?>"><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Esposa</label>
                <select name="id_esposa" class="form-select" required>
                    <option value="">-- Seleccione a la esposa --</option>
                    <?php foreach ($miembros as $m): ?>
                        <option value="<?= $m['id_miembro'] ?>"><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha del Matrimonio</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Lugar</label>
                <input type="text" name="lugar" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Testigos</label>
                <input type="text" name="testigos" class="form-control" placeholder="Ej: Juan y María">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="PMatrimonioList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PMatrimonioCreate();
