<?php
require_once(__DIR__ . '/../PBase.php');
require_once(__DIR__ . '/../../negocio/NMembresia.php');
require_once(__DIR__ . '/../../negocio/NMiembro.php');

class PMembresiaCreate extends PBase
{
    private NMembresia $negocioMembresia;
    private NMiembro $negocioMiembro;
    private array $miembros;

    public function __construct()
    {
        parent::__construct("Registrar Membresía");
        $this->negocioMembresia = new NMembresia();
        $this->negocioMiembro = new NMiembro();
        $this->miembros = $this->negocioMiembro->listar();

        $this->procesarFormulario();
        $this->mostrarVista();
    }

    private function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = $this->negocioMembresia->crear($_POST);
            header("Location: PMembresiaList.php?msg=" . urlencode($mensaje));
            exit;
        }
    }

    private function mostrarVista(): void
    {
        $this->renderInicioCompleto();
        ?>

        <h2>Registrar Nueva Membresía</h2>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Miembro</label>
                <select name="id_miembro" class="form-select" required>
                    <option value="">-- Selecciona un miembro --</option>
                    <?php foreach ($this->miembros as $m): ?>
                        <option value="<?= $m['id_miembro'] ?>">
                            <?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tipo de Membresía</label>
                <input type="text" name="tipo" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha de Fin</label>
                <input type="date" name="fecha_fin" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="activa">Activa</option>
                    <option value="inactiva">Inactiva</option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="PMembresiaList.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php
        $this->renderFinCompleto();
    }
}

new PMembresiaCreate();
